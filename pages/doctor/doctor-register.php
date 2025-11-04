<?php 
include_once __DIR__ . './../../src/components/header.php';
?>

<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Registo de Médicos</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Médicos</a></li>
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
                                    <span>Os campos abaixo são obrigatórios para registo dos médicos.</span>
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
                                            <label class="col-sm-2 col-form-label">Especialização</label>
                                            <div class="col-sm-10">
                                                <div class="input-group mb-2">
                                                    <select class="form-control" id="selectPosition">

                                                        <option value="">Selecione uma posição</option>
                                                        <option value="">Selecione uma especialidade</option>
                                                        <option value="1">Triagem</option>
                                                        <option value="2">Medicina</option>
                                                        <option value="3">Cirurgia geral</option>
                                                        <option value="4">Ortopedista</option>
                                                        <option value="5">Neurocirugiao</option>
                                                        <option value="6">Geneco obstetra</option>
                                                        <option value="7">Medico internista*</option>
                                                        <option value="8">Cardiologista</option>
                                                        <option value="9">Urologista + Nefrologista</option>
                                                        <option value="10">Pediatra</option>
                                                        <option value="11">Nutricionista</option>
                                                        <option value="12">Tecnico Raio X</option>
                                                        <option value="13">Tecnico de Laboratorio</option>
                                                        <option value="14">Tecnico Farmaceutico </option>
                                                        <option value="14">Estomatologista </option>
                                                        <option value="14">Otorirnolaringologista </option>
                                                        <option value="14">Protese de dentes</option>
                                                        <option value="15">Diversos </option>

                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-success"
                                                            onclick="addPosition()">Adicionar especialização</button>
                                                    </div>
                                                </div>
                                                <ul id="positionsList" class="list-group"></ul>
                                            </div>
                                        </div>

                                        <!-- Botão -->
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-info">Registar Medico</button>
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







<style>
/* ---- BOTÕES ---- */
.btn {
    border-radius: 25px !important;
    padding: 8px 18px !important;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
}

.btn:focus,
.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
}

/* Botão principal (azul suave) */
.btn-info {
    background: linear-gradient(135deg, #17a2b8, #138496);
    border: none;
    color: #fff;
}

.btn-info:hover {
    background: linear-gradient(135deg, #138496, #0f6b78);
}

/* Botão verde (Adicionar especialização) */
.btn-success {
    background: linear-gradient(135deg, #28a745, #218838);
    border: none;
    color: #fff;
}

.btn-success:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
}

/* Botão vermelho (Remover especialização) */
.btn-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    border: none;
    color: #fff;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #c82333, #a71d2a);
}

/* ---- LISTA DE ESPECIALIZAÇÕES ---- */
#positionsList .list-group-item {
    border-radius: 15px;
    margin-bottom: 6px;
    border: 1px solid #dee2e6;
    background: #f9f9f9;
    font-size: 0.95rem;
}

#positionsList .btn-danger {
    border-radius: 20px;
    padding: 4px 10px;
}

/* ---- BOTÃO DE SUBMISSÃO ---- */
#employeeForm button[type="submit"] {
    font-size: 1rem;
    letter-spacing: 0.5px;
    background: linear-gradient(135deg, #17a2b8, #138496);
    border: none;
    border-radius: 25px;
    padding: 10px 28px;
}

#employeeForm button[type="submit"]:hover {
    background: linear-gradient(135deg, #138496, #0f6b78);
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}
</style>


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
                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: data.message || "Consulta registada com sucesso!",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "link.php?route=19";
                });
            } else {
                Swal.fire("Erro!", data.message, "error");
            }
        })
        .catch(error => {
            console.error("Erro ao enviar:", error);
            alert("Ocorreu um erro ao tentar enviar os dados.");
        });
}
</script>