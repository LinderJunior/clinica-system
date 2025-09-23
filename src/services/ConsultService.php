<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/Consult.php'; // Modelo de consulta

class ConsultController {
    private Consult $consultModel;

    public function __construct(PDO $pdo) {
        $this->consultModel = new Consult($pdo);
    }

    /**
     * Cria uma nova consulta.
     */
    public function addConsult(
        string $date, 
        string $time, 
        string $type, 
        int $status, 
        int $patient_id, 
        int $doctor_id
    ): array {
        $consult_id = $this->consultModel->createConsult(
            $date, $time, $type, $status, $patient_id, $doctor_id
        );
        
        if ($consult_id > 0) {
            return [
                "status" => "success", 
                "message" => "Consulta cadastrada com sucesso!",
                "consult_id" => $consult_id
            ];
        } else {
            return ["status" => "error", "message" => "Erro ao cadastrar consulta."];
        }
    }

    /**
     * Retorna todas as consultas.
     */
    public function listConsults(): array {
        return ["status" => "success", "data" => $this->consultModel->getAllConsults()];
    }

    /**
     * Atualiza os dados de uma consulta.
     */
    public function editConsult(
        int $id,
        string $date, 
        string $time, 
        string $type, 
        int $status, 
        int $patient_id, 
        int $doctor_id
    ): array {
        $success = $this->consultModel->updateConsult(
            $id, $date, $time, $type, $status, $patient_id, $doctor_id
        );
        return $this->createResponse($success, "Consulta atualizada com sucesso!", "Erro ao atualizar consulta.");
    }

    /**
     * Remove uma consulta.
     */
    public function removeConsult(int $id): array {
        return $this->createResponse(
            $this->consultModel->deleteConsult($id),
            "Consulta removida com sucesso!",
            "Erro ao remover consulta."
        );
    }

    /**
     * Busca consulta por ID.
     */
    public function getConsultById(int $id): array {
        $consult = $this->consultModel->findById($id);
        return $consult ? ["status" => "success", "data" => $consult] 
                       : ["status" => "error", "message" => "Consulta não encontrada"];
    }

    /**
     * Busca consultas por data.
     */
    public function searchConsultsByDate(string $date): array {
        $consults = $this->consultModel->searchByDate($date);
        return ["status" => "success", "data" => $consults];
    }

    /**
     * Busca consultas por paciente.
     */
    public function searchConsultsByPatient(int $patient_id): array {
        $consults = $this->consultModel->searchByPatient($patient_id);
        return ["status" => "success", "data" => $consults];
    }

    /**
     * Busca consultas por médico.
     */
    public function searchConsultsByDoctor(int $doctor_id): array {
        $consults = $this->consultModel->searchByDoctor($doctor_id);
        return ["status" => "success", "data" => $consults];
    }

    /**
     * Busca consultas por status.
     */
    public function searchConsultsByStatus(int $status): array {
        $consults = $this->consultModel->searchByStatus($status);
        return ["status" => "success", "data" => $consults];
    }

    /**
     * Lista todos os pacientes para seleção.
     */
    public function getAllPatients(): array {
        return ["status" => "success", "data" => $this->consultModel->getAllPatients()];
    }

    /**
     * Lista todos os médicos para seleção.
     */
    public function getAllDoctors(): array {
        return ["status" => "success", "data" => $this->consultModel->getAllDoctors()];
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
