<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/User.php'; // Modelo do usuário

class UserController {
    private User $userModel;

    public function __construct(PDO $pdo) {
        $this->userModel = new User($pdo);
    }

    /**
     * Cria um novo usuário.
     */
    public function addUser(string $username, string $password, int $employee_id, int $role_id): array {
        return $this->createResponse(
            $this->userModel->createUser($username, $password, $employee_id, $role_id),
            "Usuário criado com sucesso!",
            "Erro ao criar usuário."
        );
    }

    /**
     * Retorna todos os usuários.
     */
    public function listUsers(): array {
        return ["status" => "success", "data" => $this->userModel->getAllUsers()];
    }


    public function editUser(int $id, string $username, string $employee_id, $role_id): array {
        $success = $this->userModel->updateUser($id, $username, $employee_id, $role_id);
        return $this->createResponse($success, "Usuário atualizado com sucesso!", "Erro ao atualizar usuário.");
    }

    /**
     * Remove um usuário.
     */
    public function removeUser(int $id): array {
        return $this->createResponse(
            $this->userModel->deleteUser($id),
            "Usuário removido com sucesso!",
            "Erro ao remover usuário."
        );
    }


        // Função para atualizar a senha do usuário
    public function updatePassword(int $id, string $newPassword): array {
            // Verificar se a senha é válida (não vazia)
            if (empty($newPassword)) {
                return ["status" => "error", "message" => "A nova senha não pode ser vazia."];
            }
    
            // Chama o método da classe User para atualizar a senha
            $success = $this->userModel->updatePassword($id, $newPassword);
    
            // Retorna a resposta conforme o sucesso ou falha
            return $success 
                ? ["status" => "success", "message" => "Senha atualizada com sucesso."]
                : ["status" => "error", "message" => "Erro ao atualizar a senha."];
        }

    /**
     * Busca usuário por ID.
     */
    public function getUserById(int $id): array {
        $user = $this->userModel->findById($id);
        return $user ? ["status" => "success", "data" => $user] 
                     : ["status" => "error", "message" => "Usuário não encontrado"];
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
