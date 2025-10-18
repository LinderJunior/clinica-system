<?php 
include_once __DIR__ . './../../src/components/header.php';
?>

<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Registo de Funcionários</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Funcionários</a></li>
                        <li class="breadcrumb-item"><a href="#!">Registo</a></li>
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
                                    <h5>Preencha o formulário</h5>
                                    <span>Os campos abaixo são obrigatórios para registo de funcionários.</span>
                                </div>
                                <div class="card-block">

                                    <form id="employeeForm" onsubmit="submitForm(event)">
                                        <input hidden type="text" id="doctor" value="1" `>

                                        <!-- Nome -->
                                        <div class="form-group row">
                                            <label for="txtnome" class="col-sm-2 col-form-label">Nome Completo</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtnome"
                                                    placeholder="Ex: Pedro Nunes Linder" required>
                                            </div>
                                        </div>

                                        <!-- Numero de BI -->
                                        <div class="form-group row">
                                            <label for="txtnumerobi" class="col-sm-2 col-form-label">Número de
                                                B.I</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtnumerobi"
                                                    placeholder="Ex: 003456789LA064" required>
                                            </div>
                                        </div>

                                        <!-- Telefone -->
                                        <div class="form-group row">
                                            <label for="txttelefone" class="col-sm-2 col-form-label">Número de
                                                Telefone</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txttelefone"
                                                    placeholder="Ex: 945678901" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Posições</label>
                                            <div class="col-sm-10">
                                                <div class="input-group mb-2">
                                                    <select class="form-control" id="selectPosition">
                                                        <option value="">Selecione uma posição</option>
                                                        <option value="1">Gestor</option>
                                                        <option value="2">Motorista</option>
                                                        <option value="3">Caixa</option>
                                                        <option value="4">Vendedor</option>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-success"
                                                            onclick="addPosition()">Adicionar</button>
                                                    </div>
                                                </div>
                                                <ul id="positionsList" class="list-group"></ul>
                                            </div>
                                        </div>

                                        <!-- Botão -->
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-info">Registar Funcionário</button>
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
</div>

<script>
let positions = []; // vai guardar os IDs das posições escolhidas

function addPosition() {
    const select = document.getElementById("selectPosition");
    const value = select.value;
    const text = select.options[select.selectedIndex].text;

    if (value && !positions.includes(parseInt(value))) {
        positions.push(parseInt(value));

        const li = document.createElement("li");
        li.className = "list-group-item d-flex justify-content-between align-items-center";
        li.textContent = text;

        const removeBtn = document.createElement("button");
        removeBtn.className = "btn btn-danger btn-sm";
        removeBtn.textContent = "Remover";
        removeBtn.onclick = function() {
            positions = positions.filter(id => id !== parseInt(value));
            li.remove();
        };

        li.appendChild(removeBtn);
        document.getElementById("positionsList").appendChild(li);
    }
}

function submitForm(event) {
    event.preventDefault();

    const formData = {
        action: "add",
        name: document.getElementById("txtnome").value,
        bi: document.getElementById("txtnumerobi").value,
        phoneNumber: document.getElementById("txttelefone").value,
        doctor: document.getElementById("doctor").value,
        positionIds: positions
    };

    fetch("routes/employeeRoutes.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message);
                window.location.href = "link.php?route=3";
            } else {
                alert("Erro: " + data.message);
            }
        })
        .catch(error => {
            console.error("Erro ao enviar:", error);
            alert("Ocorreu um erro ao tentar enviar os dados.");
        });
}
</script>