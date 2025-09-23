<?php
/**
 * Modelo para a tabela medication
 */
class Medication {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Cria um novo medicamento
     */
    public function createMedication(
        string $name, 
        string $type, 
        string $dateProduction, 
        string $dateExpiry, 
        int $qty, 
        int $loteNumber, 
        float $purchasePrice, 
        float $salePrice, 
        string $registationDate, 
        string $description, 
        int $user_id
    ): bool {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO medication (
                    name, type, dateProduction, dateExpiry, qty, 
                    loteNumber, purchasePrice, salePrice, registationDate, 
                    description, user_id
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            return $stmt->execute([
                $name, $type, $dateProduction, $dateExpiry, $qty, 
                $loteNumber, $purchasePrice, $salePrice, $registationDate, 
                $description, $user_id
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao criar medicamento: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retorna todos os medicamentos
     */
    public function getAllMedications(): array {
        try {
            $stmt = $this->pdo->query("
                SELECT m.*, u.username as user_name 
                FROM medication m
                LEFT JOIN user u ON m.user_id = u.id
                ORDER BY m.name ASC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar medicamentos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca um medicamento pelo ID
     */
    public function findById(int $id): ?array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT m.*, u.username as user_name 
                FROM medication m
                LEFT JOIN user u ON m.user_id = u.id
                WHERE m.id = ?
            ");
            $stmt->execute([$id]);
            $medication = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $medication ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar medicamento: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Atualiza os dados de um medicamento
     */
    public function updateMedication(
        int $id,
        string $name, 
        string $type, 
        string $dateProduction, 
        string $dateExpiry, 
        int $qty, 
        int $loteNumber, 
        float $purchasePrice, 
        float $salePrice, 
        string $registationDate, 
        string $description, 
        int $user_id
    ): bool {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE medication 
                SET name = ?, type = ?, dateProduction = ?, dateExpiry = ?, 
                    qty = ?, loteNumber = ?, purchasePrice = ?, salePrice = ?, 
                    registationDate = ?, description = ?, user_id = ?
                WHERE id = ?
            ");
            
            return $stmt->execute([
                $name, $type, $dateProduction, $dateExpiry, $qty, 
                $loteNumber, $purchasePrice, $salePrice, $registationDate, 
                $description, $user_id, $id
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar medicamento: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove um medicamento
     */
    public function deleteMedication(int $id): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM medication WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erro ao excluir medicamento: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca medicamentos por nome (pesquisa parcial)
     */
    public function searchByName(string $name): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT m.*, u.username as user_name 
                FROM medication m
                LEFT JOIN user u ON m.user_id = u.id
                WHERE m.name LIKE ? 
                ORDER BY m.name ASC
            ");
            $stmt->execute(['%' . $name . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao pesquisar medicamentos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca medicamentos por tipo (pesquisa parcial)
     */
    public function searchByType(string $type): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT m.*, u.username as user_name 
                FROM medication m
                LEFT JOIN user u ON m.user_id = u.id
                WHERE m.type LIKE ? 
                ORDER BY m.name ASC
            ");
            $stmt->execute(['%' . $type . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao pesquisar medicamentos por tipo: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca medicamentos com estoque baixo (abaixo de um limite)
     */
    public function getLowStockMedications(int $limit = 10): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT m.*, u.username as user_name 
                FROM medication m
                LEFT JOIN user u ON m.user_id = u.id
                WHERE m.qty <= ?
                ORDER BY m.qty ASC
            ");
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar medicamentos com estoque baixo: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca medicamentos próximos da data de validade
     */
    public function getExpiringMedications(int $daysThreshold = 30): array {
        try {
            $futureDate = date('Y-m-d', strtotime("+{$daysThreshold} days"));
            
            $stmt = $this->pdo->prepare("
                SELECT m.*, u.username as user_name,
                       DATEDIFF(m.dateExpiry, CURDATE()) as days_until_expiry
                FROM medication m
                LEFT JOIN user u ON m.user_id = u.id
                WHERE m.dateExpiry <= ?
                AND m.dateExpiry >= CURDATE()
                ORDER BY m.dateExpiry ASC
            ");
            $stmt->execute([$futureDate]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar medicamentos próximos da validade: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtém todos os usuários para seleção
     */
    public function getAllUsers(): array {
        try {
            $stmt = $this->pdo->query("SELECT id, username FROM user ORDER BY username ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar usuários: " . $e->getMessage());
            return [];
        }
    }
}
?>
