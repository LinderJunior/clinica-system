<?php
include_once __DIR__ . '/../../config/database.php';

class AuthService {
    public static function login($email, $password) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE useremail = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['userid'] = $user['userid'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['useremail'] = $user['useremail'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['filial_id'] = $user['filial_id'];

            return $user['role']; // Retorna o tipo de usuário
        }
        return false; // Falha na autenticação
    }
}
?>
