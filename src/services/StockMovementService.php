<?php

class StockMovementService {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Criar um novo movimento de estoque
     */
    public function createStockMovement(int $medicationId, int $quantity): array {
        try {
            // Iniciar transação
            $this->pdo->beginTransaction();
            
            // Inserir movimento
            $stmt = $this->pdo->prepare("
                INSERT INTO stock_movement (medication_id, quantity, movement_date) 
                VALUES (?, ?, NOW())
            ");
            $success = $stmt->execute([$medicationId, $quantity]);
            
            if (!$success) {
                $this->pdo->rollBack();
                return [
                    'status' => 'error',
                    'message' => 'Erro ao criar movimento de estoque'
                ];
            }
            
            // Atualizar quantidade na tabela medication
            $stmt = $this->pdo->prepare("
                UPDATE medication 
                SET qty = qty + ? 
                WHERE id = ?
            ");
            $success = $stmt->execute([$quantity, $medicationId]);
            
            if (!$success) {
                $this->pdo->rollBack();
                return [
                    'status' => 'error',
                    'message' => 'Erro ao atualizar estoque do medicamento'
                ];
            }
            
            // Confirmar transação
            $this->pdo->commit();
            
            $movementId = $this->pdo->lastInsertId();
            return [
                'status' => 'success',
                'message' => 'Movimento de estoque criado com sucesso',
                'data' => ['id' => $movementId]
            ];
            
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return [
                'status' => 'error',
                'message' => 'Erro no banco de dados: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Buscar todos os movimentos de estoque com informações do medicamento
     */
    public function getAllStockMovements(): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    sm.id,
                    sm.medication_id,
                    sm.quantity,
                    sm.movement_date,
                    m.name as medication_name,
                    m.description as medication_description
                FROM stock_movement sm
                LEFT JOIN medication m ON sm.medication_id = m.id
                ORDER BY sm.movement_date DESC
            ");
            
            $stmt->execute();
            $movements = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'status' => 'success',
                'data' => $movements
            ];
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Erro ao buscar movimentos: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Buscar movimento de estoque por ID
     */
    public function getStockMovementById(int $id): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    sm.id,
                    sm.medication_id,
                    sm.quantity,
                    sm.movement_date,
                    m.name as medication_name,
                    m.description as medication_description
                FROM stock_movement sm
                LEFT JOIN medication m ON sm.medication_id = m.id
                WHERE sm.id = ?
            ");
            
            $stmt->execute([$id]);
            $movement = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($movement) {
                return [
                    'status' => 'success',
                    'data' => $movement
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Movimento não encontrado'
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Erro ao buscar movimento: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Buscar movimentos por medicamento
     */
    public function getMovementsByMedication(int $medicationId): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    sm.id,
                    sm.medication_id,
                    sm.quantity,
                    sm.movement_date,
                    m.name as medication_name,
                    m.description as medication_description
                FROM stock_movement sm
                LEFT JOIN medication m ON sm.medication_id = m.id
                WHERE sm.medication_id = ?
                ORDER BY sm.movement_date DESC
            ");
            
            $stmt->execute([$medicationId]);
            $movements = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'status' => 'success',
                'data' => $movements
            ];
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Erro ao buscar movimentos: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualizar movimento de estoque
     */
    public function updateStockMovement(int $id, int $medicationId, int $quantity): array {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE stock_movement 
                SET medication_id = ?, quantity = ?
                WHERE id = ?
            ");
            
            $success = $stmt->execute([$medicationId, $quantity, $id]);
            
            if ($success && $stmt->rowCount() > 0) {
                return [
                    'status' => 'success',
                    'message' => 'Movimento atualizado com sucesso'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Movimento não encontrado ou nenhuma alteração realizada'
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Erro ao atualizar movimento: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deletar movimento de estoque
     */
    public function deleteStockMovement(int $id): array {
        try {
            // Iniciar transação
            $this->pdo->beginTransaction();
            
            // Buscar dados do movimento antes de deletar
            $stmt = $this->pdo->prepare("SELECT medication_id, quantity FROM stock_movement WHERE id = ?");
            $stmt->execute([$id]);
            $movement = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$movement) {
                $this->pdo->rollBack();
                return [
                    'status' => 'error',
                    'message' => 'Movimento não encontrado'
                ];
            }
            
            // Deletar movimento
            $stmt = $this->pdo->prepare("DELETE FROM stock_movement WHERE id = ?");
            $success = $stmt->execute([$id]);
            
            if (!$success) {
                $this->pdo->rollBack();
                return [
                    'status' => 'error',
                    'message' => 'Erro ao deletar movimento'
                ];
            }
            
            // Reverter quantidade na tabela medication (subtrair a quantidade que foi adicionada)
            $stmt = $this->pdo->prepare("
                UPDATE medication 
                SET qty = qty - ? 
                WHERE id = ?
            ");
            $success = $stmt->execute([$movement['quantity'], $movement['medication_id']]);
            
            if (!$success) {
                $this->pdo->rollBack();
                return [
                    'status' => 'error',
                    'message' => 'Erro ao atualizar estoque do medicamento'
                ];
            }
            
            // Confirmar transação
            $this->pdo->commit();
            
            return [
                'status' => 'success',
                'message' => 'Movimento deletado com sucesso'
            ];
            
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return [
                'status' => 'error',
                'message' => 'Erro ao deletar movimento: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obter estoque atual de um medicamento
     */
    public function getCurrentStock(int $medicationId): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    id,
                    name,
                    qty as current_stock
                FROM medication 
                WHERE id = ?
            ");
            
            $stmt->execute([$medicationId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return [
                    'status' => 'success',
                    'data' => [
                        'medication_id' => $medicationId,
                        'medication_name' => $result['name'],
                        'current_stock' => (int)$result['current_stock']
                    ]
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Medicamento não encontrado'
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Erro ao buscar estoque: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Buscar movimentos por período
     */
    public function getMovementsByDateRange(string $startDate, string $endDate): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    sm.id,
                    sm.medication_id,
                    sm.quantity,
                    sm.movement_date,
                    m.name as medication_name,
                    m.description as medication_description
                FROM stock_movement sm
                LEFT JOIN medication m ON sm.medication_id = m.id
                WHERE DATE(sm.movement_date) BETWEEN ? AND ?
                ORDER BY sm.movement_date DESC
            ");
            
            $stmt->execute([$startDate, $endDate]);
            $movements = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'status' => 'success',
                'data' => $movements
            ];
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Erro ao buscar movimentos: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Relatório de estoque por medicamento
     */
    public function getStockReport(): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    m.id as medication_id,
                    m.name as medication_name,
                    m.description as medication_description,
                    m.type as medication_type,
                    m.qty as current_stock,
                    m.dateExpiry as expiry_date,
                    m.loteNumber as lote_number,
                    m.purchasePrice as purchase_price,
                    m.salePrice as sale_price,
                    COUNT(sm.id) as total_movements,
                    MAX(sm.movement_date) as last_movement_date
                FROM medication m
                LEFT JOIN stock_movement sm ON m.id = sm.medication_id
                GROUP BY m.id, m.name, m.description, m.type, m.qty, m.dateExpiry, m.loteNumber, m.purchasePrice, m.salePrice
                ORDER BY m.name
            ");
            
            $stmt->execute();
            $report = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'status' => 'success',
                'data' => $report
            ];
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Erro ao gerar relatório: ' . $e->getMessage()
            ];
        }
    }
}
?>
