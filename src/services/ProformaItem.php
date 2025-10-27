<?php

class ProformaItem {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Cria um novo item da proforma
     */
    public function createProformaItem(int $proformaId, string $description, int $quantity, float $unitPrice): bool {
        try {
            $sql = "INSERT INTO proforma_items (proforma_id, description, quantity, unit_price) 
                    VALUES (?, ?, ?, ?)";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$proformaId, $description, $quantity, $unitPrice]);
        } catch (PDOException $e) {
            error_log("Erro ao criar item da proforma: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retorna todos os itens de uma proforma
     */
    public function getItemsByProformaId(int $proformaId): array {
        try {
            $sql = "SELECT * FROM proforma_items WHERE proforma_id = ? ORDER BY id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$proformaId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar itens da proforma: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca item por ID
     */
    public function findById(int $id): ?array {
        try {
            $sql = "SELECT * FROM proforma_items WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar item por ID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Atualiza um item da proforma
     */
    public function updateProformaItem(int $id, string $description, int $quantity, float $unitPrice): bool {
        try {
            $sql = "UPDATE proforma_items SET description = ?, quantity = ?, unit_price = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$description, $quantity, $unitPrice, $id]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar item da proforma: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove um item da proforma
     */
    public function deleteProformaItem(int $id): bool {
        try {
            $sql = "DELETE FROM proforma_items WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erro ao remover item da proforma: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove todos os itens de uma proforma
     */
    public function deleteItemsByProformaId(int $proformaId): bool {
        try {
            $sql = "DELETE FROM proforma_items WHERE proforma_id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$proformaId]);
        } catch (PDOException $e) {
            error_log("Erro ao remover itens da proforma: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Calcula totais de uma proforma baseado nos itens
     */
    public function calculateProformaTotals(int $proformaId): array {
        try {
            $sql = "SELECT 
                        SUM(total_price) as subtotal,
                        COUNT(*) as total_items
                    FROM proforma_items 
                    WHERE proforma_id = ?";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$proformaId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $subtotal = floatval($result['subtotal'] ?? 0);
            $tax = $subtotal * 0.16; // 16% de IVA
            $total = $subtotal + $tax;
            
            return [
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'total_items' => intval($result['total_items'] ?? 0)
            ];
        } catch (PDOException $e) {
            error_log("Erro ao calcular totais da proforma: " . $e->getMessage());
            return [
                'subtotal' => 0,
                'tax' => 0,
                'total' => 0,
                'total_items' => 0
            ];
        }
    }

    /**
     * Cria múltiplos itens de uma vez
     */
    public function createMultipleItems(int $proformaId, array $items): bool {
        try {
            $this->pdo->beginTransaction();
            
            $sql = "INSERT INTO proforma_items (proforma_id, description, quantity, unit_price) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            
            foreach ($items as $item) {
                $stmt->execute([
                    $proformaId,
                    $item['description'],
                    $item['quantity'],
                    $item['unit_price']
                ]);
            }
            
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Erro ao criar múltiplos itens: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Atualiza múltiplos itens de uma vez
     */
    public function updateMultipleItems(int $proformaId, array $items): bool {
        try {
            $this->pdo->beginTransaction();
            
            // Remove todos os itens existentes
            $this->deleteItemsByProformaId($proformaId);
            
            // Cria os novos itens
            if (!empty($items)) {
                $this->createMultipleItems($proformaId, $items);
            }
            
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Erro ao atualizar múltiplos itens: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca itens por descrição
     */
    public function searchByDescription(string $description): array {
        try {
            $sql = "SELECT pi.*, pf.invoice_number, pf.client_name 
                    FROM proforma_items pi
                    JOIN proforma_invoices pf ON pi.proforma_id = pf.id
                    WHERE pi.description LIKE ?
                    ORDER BY pi.id DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(["%$description%"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar itens por descrição: " . $e->getMessage());
            return [];
        }
    }
}

?>
