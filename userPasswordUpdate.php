<?php 
include_once __DIR__ . '/src/services/AuthService.php';
require_once __DIR__ . '/config/database.php';

AuthService::includeHeader();

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Administrador - Alterar Senha</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
            <li class="active">Usuários</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="container">
            <h2>Alterar Senha do Usuário</h2>

            <form id="passwordForm" onsubmit="submitForm(event)">
                <input type="hidden" id="userid">
                <div class="form-group">
                    <label for="txtusername">Nome de Usuário</label>
                    <input type="text" class="form-control" id="txtusername" disabled>
                </div>
                <div class="form-group">
                    <label for="txtuseremail">Email</label>
                    <input type="email" class="form-control" id="txtuseremail" disabled>
                </div>
                <div class="form-group">
                    <label for="txtpassword">Nova Senha</label>
                    <input type="password" class="form-control" id="txtpassword" required placeholder="Nova Senha">
                </div>
                <div class="form-group">
                    <label for="txtconfirmpassword">Confirmar Nova Senha</label>
                    <input type="password" class="form-control" id="txtconfirmpassword" required placeholder="Confirmar Nova Senha">
                </div>
                <button type="submit" class="btn btn-warning">Alterar Senha</button>
                <a href="userList.php" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </section>
</div>

<script>
// Ao carregar a página, buscar os dados
document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const userid = params.get("userid");

    if (!userid) {
        alert("ID de usuário não fornecido!");
        window.location.href = "userList.php";
        return;
    }

    fetch("userRoutes.php?userid=" + userid)
        .then(response => response.json())
        .then(data => {
            if (data.status === "success" && data.data) {
                populateForm(data.data);
            } else {
                alert("Usuário não encontrado.");
                window.location.href = "userList.php";
            }
        })
        .catch(error => {
            console.error("Erro ao buscar dados do usuário:", error);
            alert("Erro ao carregar dados.");
        });
});

function populateForm(user) {
    document.getElementById("userid").value = user.userid;
    document.getElementById("txtusername").value = user.username;
    document.getElementById("txtuseremail").value = user.useremail;
}

// Submissão do formulário
function submitForm(event) {
    event.preventDefault();

    const password = document.getElementById("txtpassword").value;
    const confirmPassword = document.getElementById("txtconfirmpassword").value;

    if (password !== confirmPassword) {
        swal("Erro!", "As senhas não coincidem.", "error");
        return;
    }

    const formData = {
        action: "updatePassword",
        userid: parseInt(document.getElementById("userid").value),
        password: password
    };

    fetch("userRoutes.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            swal("Sucesso!", "Senha alterada com sucesso!", "success")
                .then(() => window.location.href = "userList.php");
        } else {
            swal("Erro!", data.message, "error");
        }
    })
    .catch(error => {
        console.error("Erro:", error);
        swal("Erro!", "Erro ao alterar a senha.", "error");
    });
}
</script>
