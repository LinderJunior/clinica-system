<?php
session_start();
include_once __DIR__ . '/src/services/AuthService.php';

$errormsg = "";

// Função de login
function loginUser($username, $password) {
    $role_id = AuthService::login($username, $password);

    if ($role_id) {
        // Verifica se existe um parâmetro de rota
        if (isset($_GET['route'])) {
            // Redireciona para dashboard com o parâmetro de rota
            header("Location: link.php?route=" . $_GET['route']);
        } else {
            // Redireciona para dashboard (página inicial)
            header("Location: link.php?route=1");
        }
        exit();
    } else {
        return "Credenciais inválidas. Tente novamente.";
    }
}

// Processa POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
   $username = htmlspecialchars(trim($_POST['txt_username'] ?? ''));
    $password = htmlspecialchars(trim($_POST['txt_password'] ?? ''));


    if (!empty($username) && !empty($password)) {
        $errormsg = loginUser($username, $password);
    } else {
        $errormsg = "Por favor, preencha todos os campos.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Clinica | Sistema de Gestão</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Fontes e ícones -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Estilos básicos -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>

<body>

    <?php
// Incluir o arquivo de login da pasta pages/users
include_once __DIR__ . '/pages/users/login.php';
?>

    <!-- Scripts básicos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>