<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/Employee.php'; // Modelo de funcionário

class EmployeeController {
    private Employee $employeeModel;

    public function __construct(PDO $pdo) {
        $this->employeeModel = new Employee($pdo);
    }

    /**
     * Cria um novo funcionário.
     */
    public function addEmployee(string $name, string $bi, string $phoneNumber, string $doctor, array $positionIds): array {
        return $this->createResponse(
            $this->employeeModel->createEmployee($name, $bi, $phoneNumber, $doctor, $positionIds),
            "Funcionário cadastrado com sucesso!",
            "Erro ao cadastrar funcionário."
        );
    }

    /**
     * Retorna todos os funcionários.
     */
    public function listEmployees(): array {
        return ["status" => "success", "data" => $this->employeeModel->getAllEmployees()];
    }

    public function listDoctors(): array {
    return ["status" => "success", "data" => $this->employeeModel->getAllDoctors()];
}








    /**
     * Atualiza os dados de um funcionário.
     */
    public function editEmployee(int $id, string $name, string $bi, string $phoneNumber, array $positionIds): array {
        $success = $this->employeeModel->updateEmployee($id, $name, $bi, $phoneNumber, $positionIds);
        return $this->createResponse($success, "Funcionário atualizado com sucesso!", "Erro ao atualizar funcionário.");
    }

    /**
     * Remove um funcionário.
     */
    public function removeEmployee(int $id): array {
        return $this->createResponse(
            $this->employeeModel->deleteEmployee($id),
            "Funcionário removido com sucesso!",
            "Erro ao remover funcionário."
        );
    }

    /**
     * Busca funcionário por ID.
     */
    public function getEmployeeById(int $id): array {
        $employee = $this->employeeModel->findById($id);
        return $employee ? ["status" => "success", "data" => $employee] 
                       : ["status" => "error", "message" => "Funcionário não encontrado"];
    }

    /**
     * Busca funcionários por nome.
     */
    public function searchEmployeesByName(string $name): array {
        $employees = $this->employeeModel->searchByName($name);
        return ["status" => "success", "data" => $employees];
    }

    /**
     * Lista todas as posições/cargos disponíveis.
     */
    public function getAllPositions(): array {
        return ["status" => "success", "data" => $this->employeeModel->getAllPositions()];
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