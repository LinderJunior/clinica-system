<?php 
include_once __DIR__ . './../../src/components/header.php';
?>

<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Registo de Diagnóstico</h5>
                        <span>Preencha as informações abaixo para registar um novo diagnóstico</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Diagnósticos</a></li>
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
                                    <h5>Formulário de Diagnóstico</h5>
                                    <span>Utilize este formulário para registar o diagnóstico associado à
                                        consulta.</span>
                                </div>
                                <div class="card-block">

                                    <form id="diagnosticForm" onsubmit="submitForm(event)">

                                        <!-- Detalhes -->
                                        <div class="form-group row">
                                            <label for="txtdetails" class="col-sm-2 col-form-label">Detalhes do
                                                Diagnóstico</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="txtdetails"
                                                    placeholder="Descreva o diagnóstico" required></textarea>
                                            </div>
                                        </div>

                                        <!-- Ficheiro -->
                                        <div class="form-group row">
                                            <label for="txtfile" class="col-sm-2 col-form-label">Ficheiro (Exame /
                                                Relatório)</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtfile"
                                                    placeholder="Exemplo: exame_glicemia.pdf" required>
                                            </div>
                                        </div>

                                        <!-- Consulta -->
                                        <div class="form-group row">
                                            <label for="txtconsult" class="col-sm-2 col-form-label">Consulta
                                                Associada</label>
                                            <div class="col-sm-10">
                                                <select id="txtconsult" class="form-control" required>
                                                    <option value="">Selecione a consulta</option>
                                                    <option value="1">Consulta de Rotina - João Manuel</option>
                                                    <option value="2">Consulta de Seguimento - Maria José</option>
                                                    <option value="3">Consulta de Pediatria - Carla Gomes</option>
                                                    <option value="4">Consulta de Ginecologia - Ana Paula</option>
                                                    <option value="5">Consulta de Cardiologia - Pedro Nunes</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Médico -->
                                        <div class="form-group row">
                                            <label for="txtdoctor" class="col-sm-2 col-form-label">Médico
                                                Responsável</label>
                                            <div class="col-sm-10">
                                                <select id="txtdoctor" class="form-control" required>
                                                    <option value="">Selecione o médico</option>
                                                    <option value="1">Dr. António Mucavele</option>
                                                    <option value="2">Dra. Carla Mendes</option>
                                                    <option value="3">Dr. Júlio Macuácua</option>
                                                    <option value="4">Dra. Sandra Nhantumbo</option>
                                                    <option value="5">Dr. Paulo Matola</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Botão -->
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-info">
                                                    <i class="feather icon-save"></i> Registar Diagnóstico
                                                </button>
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

    <div id="styleSelector"></div>
</div>

<script>
function submitForm(event) {
    event.preventDefault();

    const formData = {
        action: "add",
        details: document.getElementById("txtdetails").value,
        file: document.getElementById("txtfile").value,
        consult_id: Number(document.getElementById("txtconsult").value),
        doctor_id: Number(document.getElementById("txtdoctor").value)
    };

    fetch("routes/diagnosisRoutes.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                alert("Sucesso!", "Diagnóstico registado com sucesso!", "success");
                window.location.href = "link.php?route=9";
            } else {
                alert("Erro!", data.message, "error");
            }
        })
        .catch(err => {
            console.error("Erro ao registar diagnóstico:", err);
            alert("Erro!", "Ocorreu um erro inesperado.", "error");
        });
}
</script>