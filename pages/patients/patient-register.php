<?php 
include_once __DIR__ . './../../src/components/header.php';

?>

<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">

                    <div class="d-inline">
                        <h5>Registo de Pacientes</h5>

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
                                    <h5>Prencha o formulario</h5>
                                    <span>Add class of <code>.form-control</code> with
                                        <code>&lt;input&gt;</code> tag</span>
                                </div>
                                <div class="card-block">

                                    <!-- LINDERCHECK: CONTEUDO AQUI, SEJA TABELA,CARD, LISTA OU QUALQUER COISA  -->
                                    <form id="userForm" onsubmit="submitForm(event)">
                                        <!-- Username -->
                                        <div class="form-group row">
                                            <label for="txtnomepaciente" class="col-sm-2 col-form-label">Nome do
                                                Paciente</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtnomepaciente"
                                                    placeholder="Nome de Usuário" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="txtdatanascimento" class="col-sm-2 col-form-label">Data de
                                                Nascimento</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="txtdatanascimento"
                                                    placeholder="Data de Nascimento" required>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="txtnumerobi" class="col-sm-2 col-form-label">
                                                Numero de B.I</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtnumerobi"
                                                    placeholder="Numero de B.I" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="txtprovincia" class="col-sm-2 col-form-label">
                                                Provincia</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtprovincia"
                                                    placeholder="Provincia" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="txcidade" class="col-sm-2 col-form-label">
                                                Cidade</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtcidade"
                                                    placeholder="Cidade" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="txtbairro" class="col-sm-2 col-form-label">
                                                Bairro</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtbairro"
                                                    placeholder="Bairro" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="txttelefone" class="col-sm-2 col-form-label">
                                                Numero de Telefone</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txttelefone"
                                                    placeholder="Numero de Telefone" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="txtiswhatsapp" class="col-sm-2 col-form-label">
                                                Tem WhatsApp</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtiswhatsapp"
                                                    placeholder="Is WhatsApp" required>
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
        name: document.getElementById("txtnomepaciente").value,
        dateBirth: document.getElementById("txtdatanascimento").value,
        bi: document.getElementById("txtnumerobi").value,
        province: document.getElementById("txtprovincia").value,
        city: document.getElementById("txtcidade").value,
        neighborhood: document.getElementById("txtbairro").value,
        phoneNumber: document.getElementById("txttelefone").value,
        iswhatsapp: document.getElementById("txtiswhatsapp").value
    };

    sendFormData(formData);
}

function sendFormData(formData) {
    fetch("routes/patientRoutes.php", {
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
        window.location.href = "link.php?route=3";

    } else {
        alert("Erro: " + data.message);
    }
}

function handleError(error) {
    console.error("Erro ao enviar a requisição:", error);
    alert("Ocorreu um erro ao tentar enviar os dados.");
}
</script>