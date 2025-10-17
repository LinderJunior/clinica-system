<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/ClientWeight.php';

class ClientWeightController {
    private ClientWeight $clientWeightModel;

    public function __construct(PDO $pdo) {
        $this->clientWeightModel = new ClientWeight($pdo);
    }

    /**
     * Cria um novo registro de peso do cliente
     */
    public function addClientWeight(int $clientId, float $height, float $weight, ?float $bmi = null, ?string $classification = null): array {
        return $this->createResponse(
            $this->clientWeightModel->createClientWeight($clientId, $height, $weight, $bmi, $classification),
            "Registro de peso cadastrado com sucesso!",
            "Erro ao cadastrar registro de peso."
        );
    }

    /**
     * Retorna todos os registros de peso
     */
    public function listClientWeights(): array {
        return ["status" => "success", "data" => $this->clientWeightModel->getAllClientWeights()];
    }

    /**
     * Atualiza os dados de um registro de peso
     */
    public function editClientWeight(int $id, int $clientId, float $height, float $weight, ?float $bmi = null, ?string $classification = null): array {
        $success = $this->clientWeightModel->updateClientWeight($id, $clientId, $height, $weight, $bmi, $classification);
        return $this->createResponse($success, "Registro de peso atualizado com sucesso!", "Erro ao atualizar registro de peso.");
    }

    /**
     * Remove um registro de peso
     */
    public function removeClientWeight(int $id): array {
        return $this->createResponse(
            $this->clientWeightModel->deleteClientWeight($id),
            "Registro de peso removido com sucesso!",
            "Erro ao remover registro de peso."
        );
    }

    /**
     * Busca registro de peso por ID
     */
    public function getClientWeightById(int $id): array {
        $weight = $this->clientWeightModel->findById($id);
        return $weight ? ["status" => "success", "data" => $weight] 
                       : ["status" => "error", "message" => "Registro de peso não encontrado"];
    }

    /**
     * Busca registros de peso por cliente
     */
    public function getClientWeightsByClientId(int $clientId): array {
        $weights = $this->clientWeightModel->findByClientId($clientId);
        return ["status" => "success", "data" => $weights];
    }

    /**
     * Busca registros de peso por período
     */
    public function getClientWeightsByDateRange(string $startDate, string $endDate, ?int $clientId = null): array {
        $weights = $this->clientWeightModel->findByDateRange($startDate, $endDate, $clientId);
        return ["status" => "success", "data" => $weights];
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
