<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/Role.php'; // Modelo de função/papel

class RoleController {
    private Role $roleModel;

    public function __construct(PDO $pdo) {
        $this->roleModel = new Role($pdo);
    }

    /**
     * Cria uma nova função/papel.
     */
    public function addRole(string $role): array {
        return $this->createResponse(
            $this->roleModel->createRole($role),
            "Função/papel cadastrado com sucesso!",
            "Erro ao cadastrar função/papel."
        );
    }

    /**
     * Retorna todas as funções/papéis.
     */
    public function listRoles(): array {
        return ["status" => "success", "data" => $this->roleModel->getAllRoles()];
    }

    /**
     * Atualiza os dados de uma função/papel.
     */
    public function editRole(int $id, string $role): array {
        $success = $this->roleModel->updateRole($id, $role);
        return $this->createResponse($success, "Função/papel atualizado com sucesso!", "Erro ao atualizar função/papel.");
    }

    /**
     * Remove uma função/papel.
     */
    public function removeRole(int $id): array {
        return $this->createResponse(
            $this->roleModel->deleteRole($id),
            "Função/papel removido com sucesso!",
            "Erro ao remover função/papel."
        );
    }

    /**
     * Busca função/papel por ID.
     */
    public function getRoleById(int $id): array {
        $role = $this->roleModel->findById($id);
        return $role ? ["status" => "success", "data" => $role] 
                     : ["status" => "error", "message" => "Função/papel não encontrado"];
    }

    /**
     * Busca funções/papéis por nome.
     */
    public function searchRolesByName(string $role): array {
        $roles = $this->roleModel->searchByName($role);
        return ["status" => "success", "data" => $roles];
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
