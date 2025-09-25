<?php 
include_once __DIR__ . './../../src/components/header.php';
include_once __DIR__ . '.';
?>

<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">

                    <div class="d-inline">
                        <h5>Registo de Usuario</h5>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Form Components</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Basic Form Inputs</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">

        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
                                <div class="card-header">
                                    <h5>TITULO DA TABELA/FORMULARIO</h5>
                                    <span>Add class of <code>.form-control</code> with
                                        <code>&lt;input&gt;</code> tag</span>
                                </div>
                                <div class="card-block">

                                    <!-- LINDERCHECK: CONTEUDO AQUI, SEJA TABELA,CARD, LISTA OU QUALQUER COISA  -->
                                    <form id="userForm" onsubmit="submitForm(event)">
                                        <!-- Username -->
                                        <div class="form-group row">
                                            <label for="txtusername" class="col-sm-2 col-form-label">Nome de
                                                Usuário</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtusername"
                                                    placeholder="Nome de Usuário" required>
                                            </div>
                                        </div>

                                        <!-- Password -->
                                        <div class="form-group row">
                                            <label for="txtpassword" class="col-sm-2 col-form-label">Senha</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="txtpassword"
                                                    placeholder="Senha" required>
                                            </div>
                                        </div>

                                        <!-- Employee ID -->
                                        <div class="form-group row">
                                            <label for="txtemployee" class="col-sm-2 col-form-label">ID do
                                                Funcionário</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" id="txtemployee"
                                                    placeholder="ID do Funcionário" required>
                                            </div>
                                        </div>

                                        <!-- Role -->
                                        <div class="form-group row">
                                            <label for="txtrole" class="col-sm-2 col-form-label">Função</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="txtrole" required>
                                                    <option value="">Selecione o papel</option>
                                                    <option value="1">Admin</option>
                                                    <option value="2">User</option>
                                                    <option value="3">Caixa</option>
                                                    <option value="4">Cobrança</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Botão -->
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-info">Adicionar Usuário</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div id="styleSelector">
        </div>
    </div>
</div>

<script>
function submitForm(event) {
    event.preventDefault();

    const formData = {
        action: "add",
        username: document.getElementById("txtusername").value,
        password: document.getElementById("txtpassword").value,
        employee_id: parseInt(document.getElementById("txtemployee").value),
        role_id: parseInt(document.getElementById("txtrole").value)
    };

    sendFormData(formData);
}

function sendFormData(formData) {
    fetch("routes/userRoutes.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => handleResponse(data))
        .catch(error => handleError(error));
}

function handleResponse(data) {
    if (data.status === "success") {
        alert(data.message);
        window.location.href = "link.php?route=19";

    } else {
        alert("Erro: " + data.message);
    }
}

function handleError(error) {
    console.error("Erro ao enviar a requisição:", error);
    alert("Ocorreu um erro ao tentar enviar os dados.");
}
</script>