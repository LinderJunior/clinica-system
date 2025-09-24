<?php
// Este arquivo contém apenas o formulário de login e sua lógica
// Não iniciar sessão aqui, pois já é iniciada no index.php

// Verificar se há mensagem de erro passada do index.php
$errormsg = $errormsg ?? "";
?>

<style>
    body {
        /* background: linear-gradient(135deg, #2980b9, #3498db) !important; */
        background: 
        linear-gradient(135deg, rgba(41, 128, 185, 0.8), rgba(52, 152, 219, 0.8)),
        url("assets/img/fundo.png");
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-size: cover, 200px;   
    }
    
    .login-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        padding: 30px;
        text-align: center;
    }
    
    .login-logo {
        width: 100px;
        height: 100px;
        margin: 0 auto 20px;
        background: white;
        border-radius: 50%;
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .login-logo img {
        max-width: 80px;
        max-height: 80px;
    }
    
    .login-title {
        color: #2c3e50;
        font-size: 24px;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .login-subtitle {
        color: #7f8c8d;
        font-size: 14px;
        margin-bottom: 30px;
    }
    
    .form-group {
        margin-bottom: 20px;
        position: relative;
    }
    
    .form-group input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        transition: border-color 0.3s;
    }
    
    .form-group input:focus {
        border-color: #3498db;
        outline: none;
    }
    
    .form-group i {
        position: absolute;
        left: 15px;
        top: 12px;
        color: #95a5a6;
    }
    
    .remember-me {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        font-size: 14px;
        color: #7f8c8d;
    }
    
    .remember-me input {
        margin-right: 8px;
    }
    
    .login-btn {
        background: #3498db;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 12px;
        width: 100%;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }
    
    .login-btn:hover {
        background: #2980b9;
    }
    
    .forgot-link {
        display: block;
        text-align: right;
        color: #3498db;
        font-size: 14px;
        text-decoration: none;
        margin-top: 10px;
    }
    
    .no-account {
        margin-top: 20px;
        font-size: 14px;
        color: #7f8c8d;
    }
    
    .no-account a {
        color: #3498db;
        text-decoration: none;
        font-weight: 600;
    }
    
    .alert {
        padding: 12px 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
</style>

<div class="login-container">
    <div class="login-logo">
        <img src="assets/png/logo1.png" alt="Logo">
    </div>
    
    <h3 class="login-title">Faça login na sua conta</h3>
    <p class="login-subtitle">Bem-vindo de volta! Entre com suas credenciais para acessar.</p>
    
    <!-- Exibir erro -->
    <?php if (!empty($errormsg)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($errormsg); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <i class="fas fa-user"></i>
            <input type="text" name="txt_username" placeholder="Nome de usuário" required>
        </div>
        
        <div class="form-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="txt_password" placeholder="Senha" required>
        </div>
        
        <div class="remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Lembrar de mim</label>
            <a href="#" class="forgot-link">Esqueceu a senha?</a>
        </div>
        
        <button type="submit" class="login-btn">Entrar</button>
    </form>
    
    <p class="no-account">Não tem uma conta? <a href="#">Contate o administrador</a></p>
</div>

<!-- Script para login via API (opcional) -->
<script>
// Descomente este código se quiser usar login via API em vez do formulário PHP
/*
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const username = document.querySelector('input[name="txt_username"]').value;
        const password = document.querySelector('input[name="txt_password"]').value;
        
        // Validação básica
        if (!username || !password) {
            showError('Por favor, preencha todos os campos.');
            return;
        }
        
        // Botão de login - mostrar estado de carregamento
        const loginBtn = document.querySelector('button[type="submit"]');
        const originalBtnText = loginBtn.textContent;
        loginBtn.textContent = 'Entrando...';
        loginBtn.disabled = true;
        
        // Enviar requisição AJAX
        fetch('/routes/index.php?route=auth', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'login',
                username: username,
                password: password
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Mostrar mensagem de sucesso antes de redirecionar
                showSuccess('Login realizado com sucesso! Redirecionando...');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            } else {
                showError(data.message);
                // Restaurar botão
                loginBtn.textContent = originalBtnText;
                loginBtn.disabled = false;
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            showError('Erro ao conectar com o servidor. Tente novamente mais tarde.');
            // Restaurar botão
            loginBtn.textContent = originalBtnText;
            loginBtn.disabled = false;
        });
    });
    
    function showError(message) {
        // Remover qualquer alerta existente
        const existingAlert = document.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        // Criar novo elemento de alerta
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger text-center';
        alertDiv.setAttribute('role', 'alert');
        alertDiv.textContent = message;
        
        // Inserir antes do botão de login
        const loginBtn = document.querySelector('button[type="submit"]');
        loginBtn.parentNode.parentNode.insertBefore(alertDiv, loginBtn.parentNode);
    }
    
    function showSuccess(message) {
        // Remover qualquer alerta existente
        const existingAlert = document.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        // Criar novo elemento de alerta
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success text-center';
        alertDiv.setAttribute('role', 'alert');
        alertDiv.textContent = message;
        
        // Inserir antes do botão de login
        const loginBtn = document.querySelector('button[type="submit"]');
        loginBtn.parentNode.parentNode.insertBefore(alertDiv, loginBtn.parentNode);
    }
});
*/
</script>
