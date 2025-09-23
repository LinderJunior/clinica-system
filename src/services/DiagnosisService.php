<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/Diagnosis.php'; // Modelo de diagnóstico

class DiagnosisController {
    private Diagnosis $diagnosisModel;

    public function __construct(PDO $pdo) {
        $this->diagnosisModel = new Diagnosis($pdo);
    }

    /**
     * Cria um novo diagnóstico.
     */
    public function addDiagnosis(
        string $details, 
        string $file, 
        int $consult_id, 
        int $doctor_id
    ): array {
        $diagnosis_id = $this->diagnosisModel->createDiagnosis(
            $details, $file, $consult_id, $doctor_id
        );
        
        if ($diagnosis_id > 0) {
            return [
                "status" => "success", 
                "message" => "Diagnóstico cadastrado com sucesso!",
                "diagnosis_id" => $diagnosis_id
            ];
        } else {
            return ["status" => "error", "message" => "Erro ao cadastrar diagnóstico."];
        }
    }

    /**
     * Retorna todos os diagnósticos.
     */
    public function listDiagnoses(): array {
        return ["status" => "success", "data" => $this->diagnosisModel->getAllDiagnoses()];
    }

    /**
     * Atualiza os dados de um diagnóstico.
     */
    public function editDiagnosis(
        int $id,
        string $details, 
        string $file, 
        int $consult_id, 
        int $doctor_id
    ): array {
        $success = $this->diagnosisModel->updateDiagnosis(
            $id, $details, $file, $consult_id, $doctor_id
        );
        return $this->createResponse($success, "Diagnóstico atualizado com sucesso!", "Erro ao atualizar diagnóstico.");
    }

    /**
     * Remove um diagnóstico.
     */
    public function removeDiagnosis(int $id): array {
        return $this->createResponse(
            $this->diagnosisModel->deleteDiagnosis($id),
            "Diagnóstico removido com sucesso!",
            "Erro ao remover diagnóstico."
        );
    }

    /**
     * Busca diagnóstico por ID.
     */
    public function getDiagnosisById(int $id): array {
        $diagnosis = $this->diagnosisModel->findById($id);
        return $diagnosis ? ["status" => "success", "data" => $diagnosis] 
                         : ["status" => "error", "message" => "Diagnóstico não encontrado"];
    }

    /**
     * Busca diagnósticos por consulta.
     */
    public function getDiagnosesByConsult(int $consult_id): array {
        $diagnoses = $this->diagnosisModel->findByConsult($consult_id);
        return ["status" => "success", "data" => $diagnoses];
    }

    /**
     * Busca diagnósticos por médico.
     */
    public function getDiagnosesByDoctor(int $doctor_id): array {
        $diagnoses = $this->diagnosisModel->findByDoctor($doctor_id);
        return ["status" => "success", "data" => $diagnoses];
    }

    /**
     * Busca diagnósticos por paciente.
     */
    public function getDiagnosesByPatient(int $patient_id): array {
        $diagnoses = $this->diagnosisModel->findByPatient($patient_id);
        return ["status" => "success", "data" => $diagnoses];
    }

    /**
     * Lista todas as consultas para seleção.
     */
    public function getAllConsults(): array {
        return ["status" => "success", "data" => $this->diagnosisModel->getAllConsults()];
    }

    /**
     * Lista todos os médicos para seleção.
     */
    public function getAllDoctors(): array {
        return ["status" => "success", "data" => $this->diagnosisModel->getAllDoctors()];
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
