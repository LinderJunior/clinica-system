<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/Recipe.php'; // Modelo de receita médica

class RecipeController {
    private Recipe $recipeModel;

    public function __construct(PDO $pdo) {
        $this->recipeModel = new Recipe($pdo);
    }

    /**
     * Cria uma nova receita médica com várias medicações.
     */
    public function addRecipe(
        string $date, 
        int $consult_id, 
        array $medications // Array de medicações com qty, dosage e medication_id
    ): array {
        try {
            $recipe_id = $this->recipeModel->createRecipe(
                $date, $consult_id, $medications
            );
            
            if ($recipe_id > 0) {
                return [
                    "status" => "success", 
                    "message" => "Receita médica cadastrada com sucesso!",
                    "recipe_id" => $recipe_id
                ];
            } else {
                return ["status" => "error", "message" => "Erro ao cadastrar receita médica."];
            }
        } catch (PDOException $e) {
            // Capturar erros específicos de estoque
            if (strpos($e->getMessage(), "Estoque insuficiente") !== false) {
                return ["status" => "error", "message" => $e->getMessage()];
            } else if (strpos($e->getMessage(), "Medicação não encontrada") !== false) {
                return ["status" => "error", "message" => $e->getMessage()];
            } else {
                return ["status" => "error", "message" => "Erro ao cadastrar receita médica: " . $e->getMessage()];
            }
        }
    }

    /**
     * Retorna todas as receitas médicas.
     */
    public function listRecipes(): array {
        return ["status" => "success", "data" => $this->recipeModel->getAllRecipes()];
    }

    /**
     * Atualiza os dados de uma receita médica.
     */
    public function editRecipe(
        int $id,
        string $date, 
        int $consult_id, 
        array $medications // Array de medicações com qty, dosage e medication_id
    ): array {
        try {
            $success = $this->recipeModel->updateRecipe(
                $id, $date, $consult_id, $medications
            );
            return $this->createResponse($success, "Receita médica atualizada com sucesso!", "Erro ao atualizar receita médica.");
        } catch (PDOException $e) {
            // Capturar erros específicos de estoque
            if (strpos($e->getMessage(), "Estoque insuficiente") !== false) {
                return ["status" => "error", "message" => $e->getMessage()];
            } else if (strpos($e->getMessage(), "Medicação não encontrada") !== false) {
                return ["status" => "error", "message" => $e->getMessage()];
            } else {
                return ["status" => "error", "message" => "Erro ao atualizar receita médica: " . $e->getMessage()];
            }
        }
    }

    /**
     * Remove uma receita médica.
     */
    public function removeRecipe(int $id): array {
        return $this->createResponse(
            $this->recipeModel->deleteRecipe($id),
            "Receita médica removida com sucesso!",
            "Erro ao remover receita médica."
        );
    }

    /**
     * Busca receita médica por ID.
     */
    public function getRecipeById(int $id): array {
        $recipe = $this->recipeModel->findById($id);
        return $recipe ? ["status" => "success", "data" => $recipe] 
                       : ["status" => "error", "message" => "Receita médica não encontrada"];
    }

    /**
     * Busca receitas médicas por consulta.
     */
    public function getRecipesByConsult(int $consult_id): array {
        $recipes = $this->recipeModel->findByConsult($consult_id);
        return ["status" => "success", "data" => $recipes];
    }

    /**
     * Busca receitas médicas por medicação.
     */
    public function getRecipesByMedication(int $medication_id): array {
        $recipes = $this->recipeModel->findByMedication($medication_id);
        return ["status" => "success", "data" => $recipes];
    }

    /**
     * Busca receitas médicas por paciente.
     */
    public function getRecipesByPatient(int $patient_id): array {
        $recipes = $this->recipeModel->findByPatient($patient_id);
        return ["status" => "success", "data" => $recipes];
    }

    /**
     * Busca receitas médicas por médico.
     */
    public function getRecipesByDoctor(int $doctor_id): array {
        $recipes = $this->recipeModel->findByDoctor($doctor_id);
        return ["status" => "success", "data" => $recipes];
    }

    /**
     * Busca receitas médicas por data.
     */
    public function getRecipesByDate(string $date): array {
        $recipes = $this->recipeModel->findByDate($date);
        return ["status" => "success", "data" => $recipes];
    }

    /**
     * Lista todas as consultas para seleção.
     */
    public function getAllConsults(): array {
        return ["status" => "success", "data" => $this->recipeModel->getAllConsults()];
    }

    /**
     * Lista todas as medicações para seleção.
     */
    public function getAllMedications(): array {
        return ["status" => "success", "data" => $this->recipeModel->getAllMedications()];
    }
    
    /**
     * Verifica o estoque disponível de uma medicação.
     */
    public function checkMedicationStock(int $medication_id): array {
        $medication = $this->recipeModel->checkMedicationStock($medication_id);
        
        if ($medication) {
            return ["status" => "success", "data" => $medication];
        } else {
            return ["status" => "error", "message" => "Medicação não encontrada"];
        }
    }

    /**
     * Gera uma resposta padronizada.
     */
    private function createResponse(bool $success, string $successMsg, string $errorMsg): array {
        return $success ? ["status" => "success", "message" => $successMsg] 
                        : ["status" => "error", "message" => $errorMsg];
    }
}
?>
