<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/Position.php'; // Modelo de posição/cargo

class PositionController {
    private Position $positionModel;

    public function __construct(PDO $pdo) {
        $this->positionModel = new Position($pdo);
    }

    /**
     * Cria uma nova posição/cargo.
     */
    public function addPosition(string $type, string $description): array {
        return $this->createResponse(
            $this->positionModel->createPosition($type, $description),
            "Posição/cargo cadastrado com sucesso!",
            "Erro ao cadastrar posição/cargo."
        );
    }

    /**
     * Retorna todas as posições/cargos.
     */
    public function listPositions(): array {
        return ["status" => "success", "data" => $this->positionModel->getAllPositions()];
    }

    /**
     * Atualiza os dados de uma posição/cargo.
     */
    public function editPosition(int $id, string $type, string $description): array {
        $success = $this->positionModel->updatePosition($id, $type, $description);
        return $this->createResponse($success, "Posição/cargo atualizado com sucesso!", "Erro ao atualizar posição/cargo.");
    }

    /**
     * Remove uma posição/cargo.
     */
    public function removePosition(int $id): array {
        return $this->createResponse(
            $this->positionModel->deletePosition($id),
            "Posição/cargo removido com sucesso!",
            "Erro ao remover posição/cargo."
        );
    }

    /**
     * Busca posição/cargo por ID.
     */
    public function getPositionById(int $id): array {
        $position = $this->positionModel->findById($id);
        return $position ? ["status" => "success", "data" => $position] 
                       : ["status" => "error", "message" => "Posição/cargo não encontrado"];
    }

    /**
     * Busca posições/cargos por tipo.
     */
    public function searchPositionsByType(string $type): array {
        $positions = $this->positionModel->searchByType($type);
        return ["status" => "success", "data" => $positions];
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
