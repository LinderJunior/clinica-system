<?php
session_start();
session_unset();
session_destroy();

// Força a expiração do cookie de sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redireciona dinamicamente para o index.php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$rootPath = dirname($_SERVER['SCRIPT_NAME'], 1);
$redirectPath = rtrim($rootPath, '/') . '/index.php';

header("Location: " . $protocol . $host . $redirectPath . "?logout=1");
exit;
?>
