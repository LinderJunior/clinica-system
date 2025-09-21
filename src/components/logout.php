<?php
session_start();

// Remove todas as variáveis de sessão
session_unset();

// Destroi a sessão
session_destroy();

// Redireciona dinamicamente para a raiz (index.php)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$rootPath = dirname($_SERVER['SCRIPT_NAME'], 1); // Caminho relativo ao script

// Se o index.php está na raiz do projeto
$redirectPath = rtrim($rootPath, '/') . '/index.php';

// Redireciona
header("Location: " . $protocol . $host . $redirectPath . "?logout=1");
exit;
