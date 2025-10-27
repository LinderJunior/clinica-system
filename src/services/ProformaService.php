<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/ProformaInvoice.php';
require_once __DIR__ . '/ProformaItem.php';

class ProformaController {
    private ProformaInvoice $proformaModel;
    private ProformaItem $itemModel;

    public function __construct(PDO $pdo) {
        $this->proformaModel = new ProformaInvoice($pdo);
        $this->itemModel = new ProformaItem($pdo);
    }

    /**
     * Cria uma nova proforma invoice
     */
    public function addProformaInvoice(string $clientName, string $issueDate, string $dueDate, 
                                     string $currency, string $status, string $notes = null, 
                                     array $items = []): array {
        try {
            // Gera número da invoice automaticamente
            $invoiceNumber = $this->proformaModel->generateNextInvoiceNumber();
            
            // Calcula totais baseado nos itens
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += floatval($item['quantity']) * floatval($item['unit_price']);
            }
            $tax = $subtotal * 0.16; // 16% IVA
            $total = $subtotal + $tax;
            
            // Cria a proforma
            $success = $this->proformaModel->createProformaInvoice(
                $invoiceNumber, $clientName, $issueDate, $dueDate, 
                $currency, $subtotal, $tax, $total, $status, $notes
            );
            
            if ($success && !empty($items)) {
                // Busca o ID da proforma criada
                $proforma = $this->proformaModel->findByInvoiceNumber($invoiceNumber);
                if ($proforma) {
                    $this->itemModel->createMultipleItems($proforma['id'], $items);
                }
            }
            
            return $this->createResponse($success, "Proforma criada com sucesso!", "Erro ao criar proforma.");
        } catch (Exception $e) {
            error_log("Erro no controller ao criar proforma: " . $e->getMessage());
            return ["status" => "error", "message" => "Erro interno do servidor."];
        }
    }

    /**
     * Retorna todas as proforma invoices
     */
    public function listProformaInvoices(): array {
        $proformas = $this->proformaModel->getAllProformaInvoices();
        
        // Adiciona contagem de itens para cada proforma
        foreach ($proformas as &$proforma) {
            $items = $this->itemModel->getItemsByProformaId($proforma['id']);
            $proforma['total_items'] = count($items);
        }
        
        return ["status" => "success", "data" => $proformas];
    }

    /**
     * Atualiza uma proforma invoice
     */
    public function editProformaInvoice(int $id, string $invoiceNumber, string $clientName, 
                                      string $issueDate, string $dueDate, string $currency, 
                                      string $status, string $notes = null, array $items = []): array {
        try {
            // Calcula totais baseado nos itens
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += floatval($item['quantity']) * floatval($item['unit_price']);
            }
            $tax = $subtotal * 0.16; // 16% IVA
            $total = $subtotal + $tax;
            
            // Atualiza a proforma
            $success = $this->proformaModel->updateProformaInvoice(
                $id, $invoiceNumber, $clientName, $issueDate, $dueDate, 
                $currency, $subtotal, $tax, $total, $status, $notes
            );
            
            if ($success) {
                // Atualiza os itens
                $this->itemModel->updateMultipleItems($id, $items);
            }
            
            return $this->createResponse($success, "Proforma atualizada com sucesso!", "Erro ao atualizar proforma.");
        } catch (Exception $e) {
            error_log("Erro no controller ao atualizar proforma: " . $e->getMessage());
            return ["status" => "error", "message" => "Erro interno do servidor."];
        }
    }

    /**
     * Remove uma proforma invoice
     */
    public function removeProformaInvoice(int $id): array {
        return $this->createResponse(
            $this->proformaModel->deleteProformaInvoice($id),
            "Proforma removida com sucesso!",
            "Erro ao remover proforma."
        );
    }

    /**
     * Busca proforma por ID com seus itens
     */
    public function getProformaInvoiceById(int $id): array {
        $proforma = $this->proformaModel->findById($id);
        
        if (!$proforma) {
            return ["status" => "error", "message" => "Proforma não encontrada"];
        }
        
        $items = $this->itemModel->getItemsByProformaId($id);
        $proforma['items'] = $items;
        
        return ["status" => "success", "data" => $proforma];
    }

    /**
     * Busca proformas por cliente
     */
    public function searchProformasByClient(string $clientName): array {
        $proformas = $this->proformaModel->searchByClientName($clientName);
        
        // Adiciona contagem de itens para cada proforma
        foreach ($proformas as &$proforma) {
            $items = $this->itemModel->getItemsByProformaId($proforma['id']);
            $proforma['total_items'] = count($items);
        }
        
        return ["status" => "success", "data" => $proformas];
    }

    /**
     * Busca proformas por status
     */
    public function getProformasByStatus(string $status): array {
        $proformas = $this->proformaModel->getByStatus($status);
        
        // Adiciona contagem de itens para cada proforma
        foreach ($proformas as &$proforma) {
            $items = $this->itemModel->getItemsByProformaId($proforma['id']);
            $proforma['total_items'] = count($items);
        }
        
        return ["status" => "success", "data" => $proformas];
    }

    /**
     * Atualiza apenas o status da proforma
     */
    public function updateProformaStatus(int $id, string $status): array {
        return $this->createResponse(
            $this->proformaModel->updateStatus($id, $status),
            "Status da proforma atualizado com sucesso!",
            "Erro ao atualizar status da proforma."
        );
    }

    /**
     * Recalcula totais da proforma baseado nos itens
     */
    public function recalculateProformaTotals(int $id): array {
        try {
            $totals = $this->itemModel->calculateProformaTotals($id);
            $success = $this->proformaModel->updateTotals(
                $id, 
                $totals['subtotal'], 
                $totals['tax'], 
                $totals['total']
            );
            
            return $this->createResponse(
                $success,
                "Totais recalculados com sucesso!",
                "Erro ao recalcular totais."
            );
        } catch (Exception $e) {
            error_log("Erro ao recalcular totais: " . $e->getMessage());
            return ["status" => "error", "message" => "Erro interno do servidor."];
        }
    }

    /**
     * Gera próximo número de invoice
     */
    public function getNextInvoiceNumber(): array {
        $nextNumber = $this->proformaModel->generateNextInvoiceNumber();
        return ["status" => "success", "data" => ["next_invoice_number" => $nextNumber]];
    }

    /**
     * Adiciona item a uma proforma existente
     */
    public function addItemToProforma(int $proformaId, string $description, int $quantity, float $unitPrice): array {
        try {
            $success = $this->itemModel->createProformaItem($proformaId, $description, $quantity, $unitPrice);
            
            if ($success) {
                // Recalcula totais
                $this->recalculateProformaTotals($proformaId);
            }
            
            return $this->createResponse($success, "Item adicionado com sucesso!", "Erro ao adicionar item.");
        } catch (Exception $e) {
            error_log("Erro ao adicionar item: " . $e->getMessage());
            return ["status" => "error", "message" => "Erro interno do servidor."];
        }
    }

    /**
     * Atualiza item de uma proforma
     */
    public function updateProformaItem(int $itemId, string $description, int $quantity, float $unitPrice): array {
        try {
            $item = $this->itemModel->findById($itemId);
            if (!$item) {
                return ["status" => "error", "message" => "Item não encontrado"];
            }
            
            $success = $this->itemModel->updateProformaItem($itemId, $description, $quantity, $unitPrice);
            
            if ($success) {
                // Recalcula totais da proforma
                $this->recalculateProformaTotals($item['proforma_id']);
            }
            
            return $this->createResponse($success, "Item atualizado com sucesso!", "Erro ao atualizar item.");
        } catch (Exception $e) {
            error_log("Erro ao atualizar item: " . $e->getMessage());
            return ["status" => "error", "message" => "Erro interno do servidor."];
        }
    }

    /**
     * Remove item de uma proforma
     */
    public function removeProformaItem(int $itemId): array {
        try {
            $item = $this->itemModel->findById($itemId);
            if (!$item) {
                return ["status" => "error", "message" => "Item não encontrado"];
            }
            
            $success = $this->itemModel->deleteProformaItem($itemId);
            
            if ($success) {
                // Recalcula totais da proforma
                $this->recalculateProformaTotals($item['proforma_id']);
            }
            
            return $this->createResponse($success, "Item removido com sucesso!", "Erro ao remover item.");
        } catch (Exception $e) {
            error_log("Erro ao remover item: " . $e->getMessage());
            return ["status" => "error", "message" => "Erro interno do servidor."];
        }
    }

    /**
     * Busca itens por descrição
     */
    public function searchItemsByDescription(string $description): array {
        $items = $this->itemModel->searchByDescription($description);
        return ["status" => "success", "data" => $items];
    }

    /**
     * Gera uma resposta padronizada
     */
    private function createResponse(bool $success, string $successMsg, string $errorMsg): array {
        return $success ? ["status" => "success", "message" => $successMsg] 
                        : ["status" => "error", "message" => $errorMsg];
    }
}
?>
