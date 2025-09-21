<?php

require_once __DIR__ . '/../../config/database.php';

class User {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Cria um novo usuário.
     */
    public function createUser(string $username, string $password, int $employee_id, int $role_id): bool {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (username, password, employee_id, role_id) 
                VALUES (:username, :password, :employee_id, :role_id)";
        return $this->executeStatement($sql, [
            'username' => $username,
            'password' => $hashedPassword,
            'employee_id' => $employee_id,
            'role_id' => $role_id
        ]);
    }

    /**
     * Retorna todos os usuários.
     */
    public function getAllUsers(): array {
        return $this->fetchAll("SELECT * FROM user");
    }

    /**
     * Atualiza os dados de um usuário.
     */
    public function updateUser(int $id, string $username, int $employee_id, int $role_id): bool {
        $sql = "UPDATE user SET username = :username, employee_id = :employee_id, role_id = :role_id 
                WHERE id = :id";
        return $this->executeStatement($sql, compact('id', 'username', 'employee_id', 'role_id'));
    }

    /**
     * Atualiza a senha do usuário.
     */
    public function updatePassword(int $userid, string $password): bool {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password = :password WHERE id = :id";
        return $this->executeStatement($sql, ['id' => $id, 'password' => $hashedPassword]);
    }

    /**
     * Exclui um usuário.
     */
    public function deleteUser(int $id): bool {
        return $this->executeStatement("DELETE FROM user WHERE id = :id", ['id' => $id]);
    }

    /**
     * Retorna um usuário pelo ID.
     */
    public function findById(int $userid): ?array {
        return $this->fetchOne("SELECT * FROM user WHERE id = :id", ['id' => $id]);
    }

    private function executeStatement(string $sql, array $params): bool {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    private function fetchAll(string $sql, array $params = []): array {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function fetchOne(string $sql, array $params = []): ?array {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}

?>
