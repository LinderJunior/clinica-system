<?php
/**
 * Modelo para a tabela recipe (receita médica)
 */
class Recipe {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Cria uma nova receita médica com várias medicações e subtrai a quantidade do estoque
     */
    public function createRecipe(
        string $date, 
        int $consult_id, 
        array $medications // Array de medicações com qty, dosage e medication_id
    ): int {
        try {
            // Iniciar transação
            $this->pdo->beginTransaction();
            
            // Verificar se há estoque suficiente para todas as medicações
            foreach ($medications as $med) {
                $stmt = $this->pdo->prepare("SELECT qty FROM medication WHERE id = ?");
                $stmt->execute([$med['medication_id']]);
                $medicationData = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$medicationData) {
                    throw new PDOException("Medicação não encontrada: ID " . $med['medication_id']);
                }
                
                if ($medicationData['qty'] < $med['qty']) {
                    throw new PDOException("Estoque insuficiente para a medicação ID " . $med['medication_id'] . 
                                           ". Disponível: " . $medicationData['qty'] . ", Solicitado: " . $med['qty']);
                }
            }
            
            // Inserir a receita principal
            $stmt = $this->pdo->prepare("
                INSERT INTO recipe (date, consult_id)
                VALUES (?, ?)
            ");
            
            $stmt->execute([$date, $consult_id]);
            $recipeId = (int)$this->pdo->lastInsertId();
            
            // Inserir cada medicação na tabela de relacionamento e atualizar o estoque
            foreach ($medications as $med) {
                // Obter o preço de venda da medicação
                $stmt = $this->pdo->prepare("SELECT salePrice FROM medication WHERE id = ?");
                $stmt->execute([$med['medication_id']]);
                $medicationData = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$medicationData) {
                    throw new PDOException("Medicação não encontrada: ID " . $med['medication_id']);
                }
                
                // Calcular o preço unitário e o preço total
                $unitPrice = $medicationData['salePrice'];
                $totalPrice = $unitPrice * $med['qty'];
                
                // Inserir na tabela recipe_medication com os preços
                $stmt = $this->pdo->prepare("
                    INSERT INTO recipe_medication (recipe_id, medication_id, qty, dosage, unit_price, total_price)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                
                $stmt->execute([
                    $recipeId, 
                    $med['medication_id'], 
                    $med['qty'], 
                    $med['dosage'],
                    $unitPrice,
                    $totalPrice
                ]);
                
                // Atualizar o estoque da medicação (subtrair a quantidade)
                $stmt = $this->pdo->prepare("
                    UPDATE medication 
                    SET qty = qty - ? 
                    WHERE id = ?
                ");
                
                $stmt->execute([$med['qty'], $med['medication_id']]);
            }
            
            // Confirmar transação
            $this->pdo->commit();
            return $recipeId;
        } catch (PDOException $e) {
            // Reverter em caso de erro
            $this->pdo->rollBack();
            error_log("Erro ao criar receita médica: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Retorna todas as receitas médicas com informações da consulta
     */
    public function getAllRecipes(): array {
        try {
            // Buscar todas as receitas com informações da consulta
            $stmt = $this->pdo->query("
                SELECT r.*, 
                       c.date as consult_date, 
                       c.time as consult_time,
                       p.name as patient_name,
                       e.name as doctor_name,
                       (SELECT COUNT(*) FROM recipe_medication rm WHERE rm.recipe_id = r.id) as medications_count
                FROM recipe r
                LEFT JOIN consult c ON r.consult_id = c.id
                LEFT JOIN patient p ON c.patient_id = p.id
                LEFT JOIN employee e ON c.doctor_id = e.id
                ORDER BY r.date DESC, r.id DESC
            ");
            $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Para cada receita, buscar suas medicações e calcular o preço total
            foreach ($recipes as &$recipe) {
                $stmt = $this->pdo->prepare("
                    SELECT rm.*, m.name as medication_name, m.type as medication_type
                    FROM recipe_medication rm
                    LEFT JOIN medication m ON rm.medication_id = m.id
                    WHERE rm.recipe_id = ?
                    ORDER BY rm.id ASC
                ");
                $stmt->execute([$recipe['id']]);
                $recipe['medications'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Calcular o preço total da receita
                $totalRecipePrice = 0;
                foreach ($recipe['medications'] as $medication) {
                    $totalRecipePrice += $medication['total_price'];
                }
                $recipe['total_price'] = $totalRecipePrice;
            }
            
            return $recipes;
        } catch (PDOException $e) {
            error_log("Erro ao listar receitas médicas: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca uma receita médica pelo ID com informações da consulta e medicações
     */
    public function findById(int $id): ?array {
        try {
            // Buscar a receita principal
            $stmt = $this->pdo->prepare("
                SELECT r.*, 
                       c.date as consult_date, 
                       c.time as consult_time,
                       p.name as patient_name,
                       e.name as doctor_name
                FROM recipe r
                LEFT JOIN consult c ON r.consult_id = c.id
                LEFT JOIN patient p ON c.patient_id = p.id
                LEFT JOIN employee e ON c.doctor_id = e.id
                WHERE r.id = ?
            ");
            $stmt->execute([$id]);
            $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$recipe) {
                return null;
            }
            
            // Buscar as medicações associadas a esta receita
            $stmt = $this->pdo->prepare("
                SELECT rm.*, m.name as medication_name, m.type as medication_type
                FROM recipe_medication rm
                LEFT JOIN medication m ON rm.medication_id = m.id
                WHERE rm.recipe_id = ?
                ORDER BY rm.id ASC
            ");
            $stmt->execute([$id]);
            $recipe['medications'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Calcular o preço total da receita
            $totalRecipePrice = 0;
            foreach ($recipe['medications'] as $medication) {
                $totalRecipePrice += $medication['total_price'];
            }
            $recipe['total_price'] = $totalRecipePrice;
            
            return $recipe;
        } catch (PDOException $e) {
            error_log("Erro ao buscar receita médica: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Atualiza os dados de uma receita médica e ajusta o estoque de medicações
     */
    public function updateRecipe(
        int $id,
        string $date, 
        int $consult_id, 
        array $medications // Array de medicações com qty, dosage e medication_id
    ): bool {
        try {
            // Iniciar transação
            $this->pdo->beginTransaction();
            
            // Obter as medicações atuais da receita para devolver ao estoque
            $stmt = $this->pdo->prepare("
                SELECT medication_id, qty 
                FROM recipe_medication 
                WHERE recipe_id = ?
            ");
            $stmt->execute([$id]);
            $currentMedications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Devolver as quantidades ao estoque
            foreach ($currentMedications as $currentMed) {
                $stmt = $this->pdo->prepare("
                    UPDATE medication 
                    SET qty = qty + ? 
                    WHERE id = ?
                ");
                $stmt->execute([$currentMed['qty'], $currentMed['medication_id']]);
            }
            
            // Verificar se há estoque suficiente para as novas medicações
            foreach ($medications as $med) {
                $stmt = $this->pdo->prepare("SELECT qty FROM medication WHERE id = ?");
                $stmt->execute([$med['medication_id']]);
                $medicationData = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$medicationData) {
                    throw new PDOException("Medicação não encontrada: ID " . $med['medication_id']);
                }
                
                if ($medicationData['qty'] < $med['qty']) {
                    throw new PDOException("Estoque insuficiente para a medicação ID " . $med['medication_id'] . 
                                           ". Disponível: " . $medicationData['qty'] . ", Solicitado: " . $med['qty']);
                }
            }
            
            // Atualizar a receita principal
            $stmt = $this->pdo->prepare("
                UPDATE recipe 
                SET date = ?, consult_id = ?
                WHERE id = ?
            ");
            
            $result = $stmt->execute([$date, $consult_id, $id]);
            
            if (!$result) {
                $this->pdo->rollBack();
                return false;
            }
            
            // Remover todas as medicações existentes
            $stmt = $this->pdo->prepare("DELETE FROM recipe_medication WHERE recipe_id = ?");
            $stmt->execute([$id]);
            
            // Inserir as novas medicações e atualizar o estoque
            foreach ($medications as $med) {
                // Obter o preço de venda da medicação
                $stmt = $this->pdo->prepare("SELECT salePrice FROM medication WHERE id = ?");
                $stmt->execute([$med['medication_id']]);
                $medicationData = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$medicationData) {
                    throw new PDOException("Medicação não encontrada: ID " . $med['medication_id']);
                }
                
                // Calcular o preço unitário e o preço total
                $unitPrice = $medicationData['salePrice'];
                $totalPrice = $unitPrice * $med['qty'];
                
                // Inserir na tabela recipe_medication com os preços
                $stmt = $this->pdo->prepare("
                    INSERT INTO recipe_medication (recipe_id, medication_id, qty, dosage, unit_price, total_price)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                
                $result = $stmt->execute([
                    $id, 
                    $med['medication_id'], 
                    $med['qty'], 
                    $med['dosage'],
                    $unitPrice,
                    $totalPrice
                ]);
                
                if (!$result) {
                    $this->pdo->rollBack();
                    return false;
                }
                
                // Atualizar o estoque da medicação (subtrair a quantidade)
                $stmt = $this->pdo->prepare("
                    UPDATE medication 
                    SET qty = qty - ? 
                    WHERE id = ?
                ");
                
                $stmt->execute([$med['qty'], $med['medication_id']]);
            }
            
            // Confirmar transação
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            // Reverter em caso de erro
            $this->pdo->rollBack();
            error_log("Erro ao atualizar receita médica: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove uma receita médica, suas medicações associadas e devolve as quantidades ao estoque
     */
    public function deleteRecipe(int $id): bool {
        try {
            // Iniciar transação
            $this->pdo->beginTransaction();
            
            // Obter as medicações da receita para devolver ao estoque
            $stmt = $this->pdo->prepare("
                SELECT medication_id, qty 
                FROM recipe_medication 
                WHERE recipe_id = ?
            ");
            $stmt->execute([$id]);
            $medications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Devolver as quantidades ao estoque
            foreach ($medications as $med) {
                $stmt = $this->pdo->prepare("
                    UPDATE medication 
                    SET qty = qty + ? 
                    WHERE id = ?
                ");
                $stmt->execute([$med['qty'], $med['medication_id']]);
            }
            
            // Remover as medicações associadas
            $stmt = $this->pdo->prepare("DELETE FROM recipe_medication WHERE recipe_id = ?");
            $stmt->execute([$id]);
            
            // Remover a receita principal
            $stmt = $this->pdo->prepare("DELETE FROM recipe WHERE id = ?");
            $result = $stmt->execute([$id]);
            
            // Confirmar transação
            $this->pdo->commit();
            return $result;
        } catch (PDOException $e) {
            // Reverter em caso de erro
            $this->pdo->rollBack();
            error_log("Erro ao excluir receita médica: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca receitas médicas por consulta
     */
    public function findByConsult(int $consult_id): array {
        try {
            // Buscar as receitas principais
            $stmt = $this->pdo->prepare("
                SELECT r.id, r.date, r.consult_id,
                       (SELECT COUNT(*) FROM recipe_medication rm WHERE rm.recipe_id = r.id) as medications_count
                FROM recipe r
                WHERE r.consult_id = ?
                ORDER BY r.date DESC, r.id DESC
            ");
            $stmt->execute([$consult_id]);
            $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Para cada receita, buscar suas medicações
            foreach ($recipes as &$recipe) {
                $stmt = $this->pdo->prepare("
                    SELECT rm.*, m.name as medication_name, m.type as medication_type
                    FROM recipe_medication rm
                    LEFT JOIN medication m ON rm.medication_id = m.id
                    WHERE rm.recipe_id = ?
                    ORDER BY rm.id ASC
                ");
                $stmt->execute([$recipe['id']]);
                $recipe['medications'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Calcular o preço total da receita
                $totalRecipePrice = 0;
                foreach ($recipe['medications'] as $medication) {
                    $totalRecipePrice += $medication['total_price'];
                }
                $recipe['total_price'] = $totalRecipePrice;
            }
            
            return $recipes;
        } catch (PDOException $e) {
            error_log("Erro ao buscar receitas médicas por consulta: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca receitas médicas por medicação
     */
    public function findByMedication(int $medication_id): array {
        try {
            // Buscar as receitas que contém a medicação especificada
            $stmt = $this->pdo->prepare("
                SELECT DISTINCT r.*, 
                       c.date as consult_date, 
                       c.time as consult_time,
                       p.name as patient_name,
                       e.name as doctor_name
                FROM recipe r
                JOIN recipe_medication rm ON r.id = rm.recipe_id
                LEFT JOIN consult c ON r.consult_id = c.id
                LEFT JOIN patient p ON c.patient_id = p.id
                LEFT JOIN employee e ON c.doctor_id = e.id
                WHERE rm.medication_id = ?
                ORDER BY r.date DESC, r.id DESC
            ");
            $stmt->execute([$medication_id]);
            $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Para cada receita, buscar suas medicações
            foreach ($recipes as &$recipe) {
                $stmt = $this->pdo->prepare("
                    SELECT rm.*, m.name as medication_name, m.type as medication_type
                    FROM recipe_medication rm
                    LEFT JOIN medication m ON rm.medication_id = m.id
                    WHERE rm.recipe_id = ?
                    ORDER BY rm.id ASC
                ");
                $stmt->execute([$recipe['id']]);
                $recipe['medications'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Calcular o preço total da receita
                $totalRecipePrice = 0;
                foreach ($recipe['medications'] as $medication) {
                    $totalRecipePrice += $medication['total_price'];
                }
                $recipe['total_price'] = $totalRecipePrice;
            }
            
            return $recipes;
        } catch (PDOException $e) {
            error_log("Erro ao buscar receitas médicas por medicação: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca receitas médicas por paciente
     */
    public function findByPatient(int $patient_id): array {
        try {
            // Buscar as receitas do paciente
            $stmt = $this->pdo->prepare("
                SELECT r.*, 
                       c.date as consult_date, 
                       c.time as consult_time,
                       e.name as doctor_name,
                       (SELECT COUNT(*) FROM recipe_medication rm WHERE rm.recipe_id = r.id) as medications_count
                FROM recipe r
                LEFT JOIN consult c ON r.consult_id = c.id
                LEFT JOIN employee e ON c.doctor_id = e.id
                WHERE c.patient_id = ?
                ORDER BY r.date DESC, r.id DESC
            ");
            $stmt->execute([$patient_id]);
            $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Para cada receita, buscar suas medicações
            foreach ($recipes as &$recipe) {
                $stmt = $this->pdo->prepare("
                    SELECT rm.*, m.name as medication_name, m.type as medication_type
                    FROM recipe_medication rm
                    LEFT JOIN medication m ON rm.medication_id = m.id
                    WHERE rm.recipe_id = ?
                    ORDER BY rm.id ASC
                ");
                $stmt->execute([$recipe['id']]);
                $recipe['medications'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Calcular o preço total da receita
                $totalRecipePrice = 0;
                foreach ($recipe['medications'] as $medication) {
                    $totalRecipePrice += $medication['total_price'];
                }
                $recipe['total_price'] = $totalRecipePrice;
            }
            
            return $recipes;
        } catch (PDOException $e) {
            error_log("Erro ao buscar receitas médicas por paciente: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca receitas médicas por médico
     */
    public function findByDoctor(int $doctor_id): array {
        try {
            // Buscar as receitas do médico
            $stmt = $this->pdo->prepare("
                SELECT r.*, 
                       c.date as consult_date, 
                       c.time as consult_time,
                       p.name as patient_name,
                       (SELECT COUNT(*) FROM recipe_medication rm WHERE rm.recipe_id = r.id) as medications_count
                FROM recipe r
                LEFT JOIN consult c ON r.consult_id = c.id
                LEFT JOIN patient p ON c.patient_id = p.id
                WHERE c.doctor_id = ?
                ORDER BY r.date DESC, r.id DESC
            ");
            $stmt->execute([$doctor_id]);
            $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Para cada receita, buscar suas medicações
            foreach ($recipes as &$recipe) {
                $stmt = $this->pdo->prepare("
                    SELECT rm.*, m.name as medication_name, m.type as medication_type
                    FROM recipe_medication rm
                    LEFT JOIN medication m ON rm.medication_id = m.id
                    WHERE rm.recipe_id = ?
                    ORDER BY rm.id ASC
                ");
                $stmt->execute([$recipe['id']]);
                $recipe['medications'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Calcular o preço total da receita
                $totalRecipePrice = 0;
                foreach ($recipe['medications'] as $medication) {
                    $totalRecipePrice += $medication['total_price'];
                }
                $recipe['total_price'] = $totalRecipePrice;
            }
            
            return $recipes;
        } catch (PDOException $e) {
            error_log("Erro ao buscar receitas médicas por médico: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca receitas médicas por data
     */
    public function findByDate(string $date): array {
        try {
            // Buscar as receitas da data especificada
            $stmt = $this->pdo->prepare("
                SELECT r.*, 
                       c.date as consult_date, 
                       c.time as consult_time,
                       p.name as patient_name,
                       e.name as doctor_name,
                       (SELECT COUNT(*) FROM recipe_medication rm WHERE rm.recipe_id = r.id) as medications_count
                FROM recipe r
                LEFT JOIN consult c ON r.consult_id = c.id
                LEFT JOIN patient p ON c.patient_id = p.id
                LEFT JOIN employee e ON c.doctor_id = e.id
                WHERE r.date = ?
                ORDER BY r.id DESC
            ");
            $stmt->execute([$date]);
            $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Para cada receita, buscar suas medicações
            foreach ($recipes as &$recipe) {
                $stmt = $this->pdo->prepare("
                    SELECT rm.*, m.name as medication_name, m.type as medication_type
                    FROM recipe_medication rm
                    LEFT JOIN medication m ON rm.medication_id = m.id
                    WHERE rm.recipe_id = ?
                    ORDER BY rm.id ASC
                ");
                $stmt->execute([$recipe['id']]);
                $recipe['medications'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Calcular o preço total da receita
                $totalRecipePrice = 0;
                foreach ($recipe['medications'] as $medication) {
                    $totalRecipePrice += $medication['total_price'];
                }
                $recipe['total_price'] = $totalRecipePrice;
            }
            
            return $recipes;
        } catch (PDOException $e) {
            error_log("Erro ao buscar receitas médicas por data: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtém todas as consultas para seleção
     */
    public function getAllConsults(): array {
        try {
            $stmt = $this->pdo->query("
                SELECT c.id, c.date, c.time, p.name as patient_name, e.name as doctor_name
                FROM consult c
                LEFT JOIN patient p ON c.patient_id = p.id
                LEFT JOIN employee e ON c.doctor_id = e.id
                ORDER BY c.date DESC, c.time DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar consultas: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtém todas as medicações para seleção
     */
    public function getAllMedications(): array {
        try {
            $stmt = $this->pdo->query("
                SELECT id, name, type, qty, salePrice
                FROM medication
                ORDER BY name ASC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar medicações: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Verifica o estoque disponível de uma medicação
     */
    public function checkMedicationStock(int $medication_id): ?array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT id, name, type, qty, salePrice
                FROM medication
                WHERE id = ?
            ");
            $stmt->execute([$medication_id]);
            $medication = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $medication ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao verificar estoque da medicação: " . $e->getMessage());
            return null;
        }
    }
}
?>
