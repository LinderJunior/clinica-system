<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/Medication.php'; // Modelo de medicamento

class MedicationController {
    private Medication $medicationModel;

    public function __construct(PDO $pdo) {
        $this->medicationModel = new Medication($pdo);
    }

    /**
     * Cria um novo medicamento.
     */
    public function addMedication(
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
    ): array {
        return $this->createResponse(
            $this->medicationModel->createMedication(
                $name, $type, $dateProduction, $dateExpiry, $qty, 
                $loteNumber, $purchasePrice, $salePrice, $registationDate, 
                $description, $user_id
            ),
            "Medicamento cadastrado com sucesso!",
            "Erro ao cadastrar medicamento."
        );
    }

    /**
     * Retorna todos os medicamentos.
     */
    public function listMedications(): array {
        return ["status" => "success", "data" => $this->medicationModel->getAllMedications()];
    }

    /**
     * Atualiza os dados de um medicamento.
     */
    public function editMedication(
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
    ): array {
        $success = $this->medicationModel->updateMedication(
            $id, $name, $type, $dateProduction, $dateExpiry, $qty, 
            $loteNumber, $purchasePrice, $salePrice, $registationDate, 
            $description, $user_id
        );
        return $this->createResponse($success, "Medicamento atualizado com sucesso!", "Erro ao atualizar medicamento.");
    }

    /**
     * Remove um medicamento.
     */
    public function removeMedication(int $id): array {
        return $this->createResponse(
            $this->medicationModel->deleteMedication($id),
            "Medicamento removido com sucesso!",
            "Erro ao remover medicamento."
        );
    }

    /**
     * Busca medicamento por ID.
     */
    public function getMedicationById(int $id): array {
        $medication = $this->medicationModel->findById($id);
        return $medication ? ["status" => "success", "data" => $medication] 
                          : ["status" => "error", "message" => "Medicamento não encontrado"];
    }

    /**
     * Busca medicamentos por nome.
     */
    public function searchMedicationsByName(string $name): array {
        $medications = $this->medicationModel->searchByName($name);
        return ["status" => "success", "data" => $medications];
    }

    /**
     * Busca medicamentos por tipo.
     */
    public function searchMedicationsByType(string $type): array {
        $medications = $this->medicationModel->searchByType($type);
        return ["status" => "success", "data" => $medications];
    }

    /**
     * Busca medicamentos com estoque baixo.
     */
    public function getLowStockMedications(int $limit = 10): array {
        $medications = $this->medicationModel->getLowStockMedications($limit);
        return ["status" => "success", "data" => $medications];
    }

    /**
     * Busca medicamentos próximos da data de validade.
     */
    public function getExpiringMedications(int $daysThreshold = 30): array {
        $medications = $this->medicationModel->getExpiringMedications($daysThreshold);
        return ["status" => "success", "data" => $medications];
    }

    /**
     * Lista todos os usuários para seleção.
     */
    public function getAllUsers(): array {
        return ["status" => "success", "data" => $this->medicationModel->getAllUsers()];
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
