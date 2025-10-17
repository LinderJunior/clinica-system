<?php
/**
 * Modelo para a tabela client_weights
 */
class ClientWeight {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Cria um novo registro de peso do cliente
     */
    public function createClientWeight(int $clientId, float $height, float $weight, ?float $bmi = null, ?string $classification = null): bool {
        try {
            // Calcular BMI se não fornecido (altura já em metros)
            if ($bmi === null) {
                $bmi = $weight / ($height ** 2);
            }
            
            // Determinar classificação se não fornecida
            if ($classification === null) {
                $classification = $this->getBMIClassification($bmi);
            }

            $stmt = $this->pdo->prepare("
                INSERT INTO client_weights (client_id, height, weight, bmi, classification)
                VALUES (?, ?, ?, ?, ?)
            ");
            
            return $stmt->execute([$clientId, $height, $weight, $bmi, $classification]);
        } catch (PDOException $e) {
            error_log("Erro ao criar registro de peso: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retorna todos os registros de peso
     */
    public function getAllClientWeights(): array {
        try {
            $stmt = $this->pdo->query("
                SELECT cw.*, p.name as client_name 
                FROM client_weights cw 
                LEFT JOIN patient p ON cw.client_id = p.id 
                ORDER BY cw.created_at DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar registros de peso: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca um registro de peso pelo ID
     */
    public function findById(int $id): ?array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT cw.*, p.name as client_name 
                FROM client_weights cw 
                LEFT JOIN patient p ON cw.client_id = p.id 
                WHERE cw.id = ?
            ");
            $stmt->execute([$id]);
            $weight = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $weight ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar registro de peso: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Busca registros de peso por cliente
     */
    public function findByClientId(int $clientId): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT cw.*, p.name as client_name 
                FROM client_weights cw 
                LEFT JOIN patient p ON cw.client_id = p.id 
                WHERE cw.client_id = ? 
                ORDER BY cw.created_at DESC
            ");
            $stmt->execute([$clientId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar registros de peso por cliente: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Atualiza os dados de um registro de peso
     */
    public function updateClientWeight(int $id, int $clientId, float $height, float $weight, ?float $bmi = null, ?string $classification = null): bool {
        try {
            // Calcular BMI se não fornecido (altura já em metros)
            if ($bmi === null) {
                $bmi = $weight / ($height ** 2);
            }
            
            // Determinar classificação se não fornecida
            if ($classification === null) {
                $classification = $this->getBMIClassification($bmi);
            }

            $stmt = $this->pdo->prepare("
                UPDATE client_weights 
                SET client_id = ?, height = ?, weight = ?, bmi = ?, classification = ?
                WHERE id = ?
            ");
            
            return $stmt->execute([$clientId, $height, $weight, $bmi, $classification, $id]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar registro de peso: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove um registro de peso
     */
    public function deleteClientWeight(int $id): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM client_weights WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erro ao excluir registro de peso: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Determina a classificação do BMI
     */
    private function getBMIClassification(float $bmi): string {
        if ($bmi < 18.5) {
            return 'Abaixo do peso';
        } elseif ($bmi < 25) {
            return 'Peso normal';
        } elseif ($bmi < 30) {
            return 'Sobrepeso';
        } elseif ($bmi < 35) {
            return 'Obesidade grau I';
        } elseif ($bmi < 40) {
            return 'Obesidade grau II';
        } else {
            return 'Obesidade grau III';
        }
    }

    /**
     * Busca registros de peso por período
     */
    public function findByDateRange(string $startDate, string $endDate, ?int $clientId = null): array {
        try {
            $sql = "
                SELECT cw.*, p.name as client_name 
                FROM client_weights cw 
                LEFT JOIN patient p ON cw.client_id = p.id 
                WHERE DATE(cw.created_at) BETWEEN ? AND ?
            ";
            $params = [$startDate, $endDate];
            
            if ($clientId !== null) {
                $sql .= " AND cw.client_id = ?";
                $params[] = $clientId;
            }
            
            $sql .= " ORDER BY cw.created_at DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar registros por período: " . $e->getMessage());
            return [];
        }
    }
}
?>
