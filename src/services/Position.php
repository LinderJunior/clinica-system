<?php
/**
 * Modelo para a tabela position
 */
class Position {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Cria uma nova posição/cargo
     */
    public function createPosition(string $type, string $description): bool {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO position (type, description)
                VALUES (?, ?)
            ");
            
            return $stmt->execute([$type, $description]);
        } catch (PDOException $e) {
            error_log("Erro ao criar posição/cargo: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retorna todas as posições/cargos
     */
    public function getAllPositions(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM position ORDER BY type ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar posições/cargos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca uma posição/cargo pelo ID
     */
    public function findById(int $id): ?array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM position WHERE id = ?");
            $stmt->execute([$id]);
            $position = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $position ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar posição/cargo: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Atualiza os dados de uma posição/cargo
     */
    public function updatePosition(int $id, string $type, string $description): bool {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE position 
                SET type = ?, description = ?
                WHERE id = ?
            ");
            
            return $stmt->execute([$type, $description, $id]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar posição/cargo: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove uma posição/cargo
     */
    public function deletePosition(int $id): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM position WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erro ao excluir posição/cargo: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca posições/cargos por tipo (pesquisa parcial)
     */
    public function searchByType(string $type): array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM position WHERE type LIKE ? ORDER BY type ASC");
            $stmt->execute(['%' . $type . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao pesquisar posições/cargos: " . $e->getMessage());
            return [];
        }
    }
}
?>
