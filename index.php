<?php
// Inclusão dos arquivos necessários
include_once __DIR__ . '/src/services/AuthService.php';
include_once 'src/components/headerLogin.php';

// Inicialização de variáveis
$message = "";
$errormsg = "";

// Função para realizar o login
// function loginUser($email, $password) {
//     $role = AuthService::login($email, $password);
    
//     if ($role) {
//         switch ($role) {
//             case 'Admin':
//                 header("Location: dashboard.php");
//                 break;
//             case 'User':
//                 header("Location: user.php");
//                 break;
//             case 'Caixa':
//                 header("Location: caixa.php");
//                 break;
//             case 'Cobranca':
//                 header("Location: cobranca.php");
//                 break;
//         }
//         exit();
//     } else {
//         return "Credenciais inválidas. Tente novamente.";
//     }
// }


function loginUser($email, $password) {
    $role = AuthService::login($email, $password);
    
    if ($role) {
        $_SESSION['role'] = $role;  // Salvar o role na sessão

        // Redirecionar para páginas principais conforme o role
        switch ($role) {
            case 'Admin':
                header("Location: dashboard.php");  // Páginas principais para Admin
                break;
            case 'Caixa':
                header("Location: dashboard.php");  // Caixa redirecionado para dashboard (ou outra página principal)
                break;
            case 'User':
                header("Location: dashboard.php");  // Usuário comum para a página principal
                break;
            case 'Cobranca':
                header("Location: cobranca.php");  // Cobranca redirecionado para a página correspondente
                break;
        }
        exit();
    } else {
        return "Credenciais inválidas. Tente novamente.";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitização de dados para evitar injeções e garantir que o formato seja adequado
    $email = filter_input(INPUT_POST, 'txt_email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'txt_password', FILTER_SANITIZE_STRING);

    // Verificando se os campos estão preenchidos antes de tentar o login
    if (!empty($email) && !empty($password)) {
        $errormsg = loginUser($email, $password);
    } else {
        $errormsg = "Por favor, preencha todos os campos.";
    }
}
?>

<div class="login-box">
    <div class="login-logo">
        <a href="index.php"><b>FARMACIA</b>LINDER</a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Insira as credenciais para iniciar a sessão</p>

        <!-- Formulário de Login -->
        <form action="" method="post">
            <!-- Campo de Email -->
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" name="txt_email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <!-- Campo de Senha -->
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Senha" name="txt_password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <!-- Links e Botões -->
            <div class="row">
                <div class="col-xs-8">
                    <a href="#" onclick="swal('Para recuperar a senha', 'Por favor, entre em contato com o administrador', 'error');">Esqueci minha senha</a>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn_login">Login</button>
                </div>
            </div>
        </form>

        <!-- Mensagem de erro -->
        <?php if (!empty($errormsg)): ?>
            <div class="alert alert-danger mt-2"><?php echo htmlspecialchars($errormsg); ?></div>
        <?php endif; ?>
    </div>
</div>
