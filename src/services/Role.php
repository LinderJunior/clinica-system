<?php
/**
 * Modelo para a tabela role
 */
class Role {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Cria uma nova função/papel
     */
    public function createRole(string $role): bool {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO role (role)
                VALUES (?)
            ");
            
            return $stmt->execute([$role]);
        } catch (PDOException $e) {
            error_log("Erro ao criar função/papel: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retorna todas as funções/papéis
     */
    public function getAllRoles(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM role ORDER BY role ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar funções/papéis: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca uma função/papel pelo ID
     */
    public function findById(int $id): ?array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM role WHERE id = ?");
            $stmt->execute([$id]);
            $role = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $role ?: null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar função/papel: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Atualiza os dados de uma função/papel
     */
    public function updateRole(int $id, string $role): bool {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE role 
                SET role = ?
                WHERE id = ?
            ");
            
            return $stmt->execute([$role, $id]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar função/papel: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove uma função/papel
     */
    public function deleteRole(int $id): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM role WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erro ao excluir função/papel: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca funções/papéis por nome (pesquisa parcial)
     */
    public function searchByName(string $role): array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM role WHERE role LIKE ? ORDER BY role ASC");
            $stmt->execute(['%' . $role . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao pesquisar funções/papéis: " . $e->getMessage());
            return [];
        }
    }
}
?>
