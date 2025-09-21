<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/../../config/database.php';

class AuthService {
    public static function login($username, $password) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['employee_id'] = $user['employee_id'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['last_activity'] = time(); // Define o início da sessão

            session_write_close();
            return $user['role_id'];
        }
        return false;
    }


    public static function includeHeader() {
        $headerPath = __DIR__ . '/../components/header.php';
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Evitar cache das páginas protegidas
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.
    
        // Verificar a role do usuário e permitir o acesso adequado
        if (isset($_SESSION['role'])) {
            // Permitir acesso para Admin, Caixa e outras roles (se necessário)
            if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Caixa') {
                require_once $headerPath;
            } else {
                // Caso a role não seja permitida, redireciona para a página de login ou erro
                header("Location: login.php");
                exit();
            }
        } else {
            // Se não houver role definida (usuário não logado), redireciona para o login
            header("Location: login.php");
            exit();
        }
    }
    
    
    public static function checkSessionAndRedirect() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    
        // Tempo de expiração: 5 minutos
        $timeout = 300;
    
        // Se não estiver logado
        if (!isset($_SESSION['id'])) {
            header("Location: /index.php?unauthorized=1");
            exit;
        }
    
        // Sessão expirada
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
            session_unset();
            session_destroy();
            header("Location: /index.php?timeout=1");
            exit;
        }
    
        // Atualiza timestamp da última atividade
        $_SESSION['last_activity'] = time();
    }
    
}
?>
