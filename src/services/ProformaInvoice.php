<?php

class ProformaInvoice {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Cria uma nova proforma invoice
     */
    public function createProformaInvoice(string $invoiceNumber, string $clientName, string $issueDate, 
                                        string $dueDate, string $currency, float $subtotal, float $tax, 
                                        float $total, string $status, string $notes = null): bool {
        try {
            $sql = "INSERT INTO proforma_invoices (invoice_number, client_name, issue_date, due_date, 
                    currency, subtotal, tax, total, status, notes) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $invoiceNumber, $clientName, $issueDate, $dueDate, 
                $currency, $subtotal, $tax, $total, $status, $notes
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao criar proforma invoice: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retorna todas as proforma invoices
     */
    public function getAllProformaInvoices(): array {
        try {
            $sql = "SELECT * FROM proforma_invoices ORDER BY created_at DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar proforma invoices: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca proforma invoice por ID
     */
    public function findById(int $id): ?array {
        try {
            $sql = "SELECT * FROM proforma_invoices WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar proforma invoice por ID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Busca proforma invoice por número
     */
    public function findByInvoiceNumber(string $invoiceNumber): ?array {
        try {
            $sql = "SELECT * FROM proforma_invoices WHERE invoice_number = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$invoiceNumber]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar proforma invoice por número: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Busca proforma invoices por cliente
     */
    public function searchByClientName(string $clientName): array {
        try {
            $sql = "SELECT * FROM proforma_invoices WHERE client_name LIKE ? ORDER BY created_at DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(["%$clientName%"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar proforma invoices por cliente: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Atualiza uma proforma invoice
     */
    public function updateProformaInvoice(int $id, string $invoiceNumber, string $clientName, 
                                        string $issueDate, string $dueDate, string $currency, 
                                        float $subtotal, float $tax, float $total, string $status, 
                                        string $notes = null): bool {
        try {
            $sql = "UPDATE proforma_invoices SET 
                    invoice_number = ?, client_name = ?, issue_date = ?, due_date = ?, 
                    currency = ?, subtotal = ?, tax = ?, total = ?, status = ?, notes = ?,
                    updated_at = CURRENT_TIMESTAMP
                    WHERE id = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $invoiceNumber, $clientName, $issueDate, $dueDate, 
                $currency, $subtotal, $tax, $total, $status, $notes, $id
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar proforma invoice: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Atualiza apenas o status da proforma invoice
     */
    public function updateStatus(int $id, string $status): bool {
        try {
            $sql = "UPDATE proforma_invoices SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$status, $id]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar status da proforma invoice: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Atualiza totais da proforma invoice
     */
    public function updateTotals(int $id, float $subtotal, float $tax, float $total): bool {
        try {
            $sql = "UPDATE proforma_invoices SET subtotal = ?, tax = ?, total = ?, 
                    updated_at = CURRENT_TIMESTAMP WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$subtotal, $tax, $total, $id]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar totais da proforma invoice: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove uma proforma invoice
     */
    public function deleteProformaInvoice(int $id): bool {
        try {
            $sql = "DELETE FROM proforma_invoices WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erro ao remover proforma invoice: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca proforma invoices por status
     */
    public function getByStatus(string $status): array {
        try {
            $sql = "SELECT * FROM proforma_invoices WHERE status = ? ORDER BY created_at DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$status]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar proforma invoices por status: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Gera próximo número de invoice
     */
    public function generateNextInvoiceNumber(): string {
        try {
            $sql = "SELECT MAX(CAST(SUBSTRING(invoice_number, 4) AS UNSIGNED)) as max_num 
                    FROM proforma_invoices WHERE invoice_number LIKE 'PF-%'";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $nextNumber = ($result['max_num'] ?? 0) + 1;
            return 'PF-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        } catch (PDOException $e) {
            error_log("Erro ao gerar número de invoice: " . $e->getMessage());
            return 'PF-000001';
        }
    }
}

?>
