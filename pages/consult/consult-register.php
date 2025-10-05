<?php 
include_once __DIR__ . './../../src/components/header.php';
?>

<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Registo de Consultas</h5>
                        <span>Formulário de agendamento e registo de consultas médicas</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Consultas</a></li>
                        <li class="breadcrumb-item"><a href="#!">Novo Registo</a></li>
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
                                    <span>Informe os dados da consulta a ser registada</span>
                                </div>
                                <div class="card-block">

                                    <!-- FORMULÁRIO DE CONSULTAS -->
                                    <form id="consultaForm" onsubmit="submitConsulta(event)">

                                        <!-- Data da Consulta -->
                                        <div class="form-group row">
                                            <label for="txtdate" class="col-sm-2 col-form-label">Data da
                                                Consulta</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="txtdate" required>
                                            </div>
                                        </div>

                                        <!-- Hora da Consulta -->
                                        <div class="form-group row">
                                            <label for="txttime" class="col-sm-2 col-form-label">Hora da
                                                Consulta</label>
                                            <div class="col-sm-10">
                                                <input type="time" class="form-control" id="txttime" required>
                                            </div>
                                        </div>

                                        <!-- Tipo de Consulta -->
                                        <div class="form-group row">
                                            <label for="txttype" class="col-sm-2 col-form-label">Tipo de
                                                Consulta</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txttype"
                                                    placeholder="Ex: Consulta de Rotina, Retorno, Urgência..." required>
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="form-group row">
                                            <label for="txtstatus" class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="txtstatus" required>
                                                    <option value="0">Pendente</option>
                                                    <option value="1">Concluída</option>
                                                    <option value="2">Cancelada</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Paciente -->
                                        <div class="form-group row">
                                            <label for="txtpatient" class="col-sm-2 col-form-label">Paciente</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="txtpatient" required>
                                                    <option value="">Selecione um Paciente</option>
                                                    <option value="1">Paciente 1</option>
                                                    <option value="2">Paciente 2</option>
                                                    <option value="3">Paciente 3</option>
                                                    <option value="4">Paciente 4</option>
                                                    <option value="5">Paciente 5</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Médico -->
                                        <div class="form-group row">
                                            <label for="txtdoctor" class="col-sm-2 col-form-label">Médico</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="txtdoctor" required>
                                                    <option value="">Selecione um Médico</option>
                                                    <option value="1">Dr. Almeida</option>
                                                    <option value="2">Dra. Sofia</option>
                                                    <option value="3">Dr. Carlos</option>
                                                    <option value="4">Dra. Joana</option>
                                                    <option value="5">Dr. Mendes</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Botão -->
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-info">
                                                    <i class="feather icon-save"></i> Adicionar Consulta
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                    <!-- FIM DO FORM -->

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div id="styleSelector"></div>
    </div>
</div>

<!-- SCRIPT -->
<script>
function submitConsulta(event) {
    event.preventDefault();

    const formData = {
        action: "add",
        date: document.getElementById("txtdate").value,
        time: document.getElementById("txttime").value,
        type: document.getElementById("txttype").value,
        status: parseInt(document.getElementById("txtstatus").value),
        patient_id: parseInt(document.getElementById("txtpatient").value),
        doctor_id: parseInt(document.getElementById("txtdoctor").value)
    };

    fetch("routes/consultRoutes.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message);
                window.location.href = "link.php?route=7";
            } else {
                swal("Erro!", data.message, "error");
            }
        })
        .catch(err => {
            console.error("Erro ao enviar a requisição:", err);
            swal("Erro!", "Falha ao tentar enviar os dados.", "error");
        });
}
</script>