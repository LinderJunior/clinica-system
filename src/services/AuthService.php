<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/database.php';

class AuthService {
    public static function login($username, $password) {
        global $pdo;
        
        // Verificar se a conexão com o banco de dados está funcionando
        if (!$pdo) {
            error_log('Erro: Conexão com o banco de dados não está disponível');
            return false;
        }
        
        try {
            // Verificar se a tabela user existe
            $checkTable = $pdo->query("SHOW TABLES LIKE 'user'");
            if ($checkTable->rowCount() == 0) {
                error_log('Erro: Tabela user não existe no banco de dados');
                return false;
            }
            
            $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                // Verificar se a senha está em formato hash
                if (strlen($user['password']) < 40) {
                    // Verificar se a senha está em texto simples
                    if ($password === $user['password']) {
                        // Atualizar a senha para o formato hash correto
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $updateStmt = $pdo->prepare("UPDATE user SET password = :password WHERE id = :id");
                        $updateStmt->execute([':password' => $hashedPassword, ':id' => $user['id']]);
                        
                        // Continuar com o login
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['employee_id'] = $user['employee_id'];
                        $_SESSION['role_id'] = $user['role_id'];
                        $_SESSION['last_activity'] = time();
                        
                        session_write_close();
                        return $user['role_id'];
                    }
                } else {
                    // Verificar se a senha está correta usando password_verify
                    if (password_verify($password, $user['password'])) {
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['employee_id'] = $user['employee_id'];
                        $_SESSION['role_id'] = $user['role_id'];
                        $_SESSION['last_activity'] = time();
                        
                        session_write_close();
                        return $user['role_id'];
                    }
                }
            }
            
            return false;
            
        } catch (PDOException $e) {
            error_log('Erro no banco de dados durante o login: ' . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log('Erro durante o login: ' . $e->getMessage());
            return false;
        }
    }

    public static function includeHeader() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Evitar cache das páginas protegidas
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Verificar se existe role e se o usuário tem permissão
        if (isset($_SESSION['role_id'])) {
            // Exemplo: só permitir Admin (1) e Caixa (2)
            if ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2) {
                // Aqui futuramente pode-se carregar o header, se existir
                return true;
            } else {
                header("Location: login.php");
                exit();
            }
        } else {
            header("Location: login.php");
            exit();
        }
    }

    public static function checkSessionAndRedirect() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $timeout = 300; // 5 minutos

        if (!isset($_SESSION['id'])) {
            header("Location: index.php?unauthorized=1");
            exit;
        }

        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
            session_unset();
            session_destroy();
            header("Location: index.php?timeout=1");
            exit;
        }

        $_SESSION['last_activity'] = time();
    }
}
?>
