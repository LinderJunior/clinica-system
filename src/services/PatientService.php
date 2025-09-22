<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/Patient.php'; // Modelo do paciente

class PatientController {
    private Patient $patientModel;

    public function __construct(PDO $pdo) {
        $this->patientModel = new Patient($pdo);
    }

    /**
     * Cria um novo paciente.
     */
    public function addPatient(string $name, string $dateBirth, string $bi, string $province, 
                              string $city, string $neighborhood, string $phoneNumber, int $iswhatsapp): array {
        return $this->createResponse(
            $this->patientModel->createPatient($name, $dateBirth, $bi, $province, $city, $neighborhood, $phoneNumber, $iswhatsapp),
            "Paciente cadastrado com sucesso!",
            "Erro ao cadastrar paciente."
        );
    }

    /**
     * Retorna todos os pacientes.
     */
    public function listPatients(): array {
        return ["status" => "success", "data" => $this->patientModel->getAllPatients()];
    }

    /**
     * Atualiza os dados de um paciente.
     */
    public function editPatient(int $id, string $name, string $dateBirth, string $bi, string $province, 
                               string $city, string $neighborhood, string $phoneNumber, int $iswhatsapp): array {
        $success = $this->patientModel->updatePatient($id, $name, $dateBirth, $bi, $province, $city, $neighborhood, $phoneNumber, $iswhatsapp);
        return $this->createResponse($success, "Paciente atualizado com sucesso!", "Erro ao atualizar paciente.");
    }

    /**
     * Remove um paciente.
     */
    public function removePatient(int $id): array {
        return $this->createResponse(
            $this->patientModel->deletePatient($id),
            "Paciente removido com sucesso!",
            "Erro ao remover paciente."
        );
    }

    /**
     * Busca paciente por ID.
     */
    public function getPatientById(int $id): array {
        $patient = $this->patientModel->findById($id);
        return $patient ? ["status" => "success", "data" => $patient] 
                       : ["status" => "error", "message" => "Paciente não encontrado"];
    }

    /**
     * Busca pacientes por nome.
     */
    public function searchPatientsByName(string $name): array {
        $patients = $this->patientModel->searchByName($name);
        return ["status" => "success", "data" => $patients];
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
