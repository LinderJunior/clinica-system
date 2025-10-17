<?php

require_once __DIR__ . '/../services/StockMovementService.php';

class StockMovementController {
    private $stockMovementService;

    public function __construct($pdo) {
        $this->stockMovementService = new StockMovementService($pdo);
    }

    /**
     * Criar novo movimento de estoque
     */
    public function createStockMovement(): array {
        try {
            // Validar método HTTP
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return [
                    'status' => 'error',
                    'message' => 'Método não permitido'
                ];
            }

            // Obter dados do POST
            $medicationId = $_POST['medication_id'] ?? null;
            $quantity = $_POST['quantity'] ?? null;

            // Validações
            if (!$medicationId || !is_numeric($medicationId)) {
                return [
                    'status' => 'error',
                    'message' => 'ID do medicamento é obrigatório e deve ser numérico'
                ];
            }

            if (!$quantity || !is_numeric($quantity)) {
                return [
                    'status' => 'error',
                    'message' => 'Quantidade é obrigatória e deve ser numérica'
                ];
            }

            // Converter para inteiros
            $medicationId = (int)$medicationId;
            $quantity = (int)$quantity;

            // Criar movimento
            return $this->stockMovementService->createStockMovement($medicationId, $quantity);

        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erro interno: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Buscar todos os movimentos ou por ID específico
     */
    public function getStockMovements(): array {
        try {
            // Verificar se foi solicitado um ID específico
            $id = $_GET['id'] ?? null;
            $medicationId = $_GET['medication_id'] ?? null;
            $startDate = $_GET['start_date'] ?? null;
            $endDate = $_GET['end_date'] ?? null;

            // Buscar por ID específico
            if ($id && is_numeric($id)) {
                return $this->stockMovementService->getStockMovementById((int)$id);
            }

            // Buscar por medicamento específico
            if ($medicationId && is_numeric($medicationId)) {
                return $this->stockMovementService->getMovementsByMedication((int)$medicationId);
            }

            // Buscar por período
            if ($startDate && $endDate) {
                return $this->stockMovementService->getMovementsByDateRange($startDate, $endDate);
            }

            // Buscar todos
            return $this->stockMovementService->getAllStockMovements();

        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erro interno: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualizar movimento de estoque
     */
    public function updateStockMovement(): array {
        try {
            // Validar método HTTP
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return [
                    'status' => 'error',
                    'message' => 'Método não permitido'
                ];
            }

            // Obter dados
            $id = $_POST['id'] ?? null;
            $medicationId = $_POST['medication_id'] ?? null;
            $quantity = $_POST['quantity'] ?? null;

            // Validações
            if (!$id || !is_numeric($id)) {
                return [
                    'status' => 'error',
                    'message' => 'ID do movimento é obrigatório'
                ];
            }

            if (!$medicationId || !is_numeric($medicationId)) {
                return [
                    'status' => 'error',
                    'message' => 'ID do medicamento é obrigatório'
                ];
            }

            if (!$quantity || !is_numeric($quantity)) {
                return [
                    'status' => 'error',
                    'message' => 'Quantidade é obrigatória'
                ];
            }

            // Converter para inteiros
            $id = (int)$id;
            $medicationId = (int)$medicationId;
            $quantity = (int)$quantity;

            // Atualizar movimento
            return $this->stockMovementService->updateStockMovement($id, $medicationId, $quantity);

        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erro interno: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deletar movimento de estoque
     */
    public function deleteStockMovement(): array {
        try {
            // Validar método HTTP
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return [
                    'status' => 'error',
                    'message' => 'Método não permitido'
                ];
            }

            // Obter ID
            $id = $_POST['id'] ?? null;

            // Validação
            if (!$id || !is_numeric($id)) {
                return [
                    'status' => 'error',
                    'message' => 'ID do movimento é obrigatório'
                ];
            }

            // Deletar movimento
            return $this->stockMovementService->deleteStockMovement((int)$id);

        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erro interno: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obter estoque atual de um medicamento
     */
    public function getCurrentStock(): array {
        try {
            $medicationId = $_GET['medication_id'] ?? null;

            if (!$medicationId || !is_numeric($medicationId)) {
                return [
                    'status' => 'error',
                    'message' => 'ID do medicamento é obrigatório'
                ];
            }

            return $this->stockMovementService->getCurrentStock((int)$medicationId);

        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erro interno: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Relatório de estoque
     */
    public function getStockReport(): array {
        try {
            return $this->stockMovementService->getStockReport();
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erro interno: ' . $e->getMessage()
            ];
        }
    }
}
?>
