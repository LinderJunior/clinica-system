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

                            <div class="card shadow-sm">
                                <div
                                    class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="feather icon-plus-circle"></i> Nova Consulta</h5>
                                    <button type="button" class="btn btn-light text-primary"
                                        onclick="gerarPDFConsulta()">
                                        <i class="feather icon-file-text"></i> Gerar PDF
                                    </button>
                                </div>

                                <div class="card-block p-4">

                                    <!-- FORMULÁRIO DE CONSULTAS -->
                                    <form id="consultaForm" onsubmit="submitConsulta(event)">

                                        <!-- Data -->
                                        <div class="form-group row">
                                            <label for="txtdate"
                                                class="col-sm-2 col-form-label font-weight-bold">Data</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="txtdate" required>
                                            </div>
                                        </div>

                                        <!-- Hora -->
                                        <div class="form-group row">
                                            <label for="txttime"
                                                class="col-sm-2 col-form-label font-weight-bold">Hora</label>
                                            <div class="col-sm-10">
                                                <input type="time" class="form-control" id="txttime" required>
                                            </div>
                                        </div>

                                        <!-- Tipo -->
                                        <div class="form-group row">
                                            <label for="txttype" class="col-sm-2 col-form-label font-weight-bold">Tipo
                                                de Consulta</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="txttype" required>
                                                    <option value="">Selecione o tipo de consulta</option>
                                                    <option value="Rotina">Consulta de Rotina</option>
                                                    <option value="Urgência">Consulta de Urgência</option>
                                                    <option value="Seguimento">Consulta de Seguimento</option>
                                                    <option value="Pediatria">Consulta de Pediatria</option>
                                                    <option value="Ginecologia">Consulta de Ginecologia</option>
                                                    <option value="Cardiologia">Consulta de Cardiologia</option>
                                                    <option value="Ortopedia">Consulta de Ortopedia</option>
                                                    <option value="Dermatologia">Consulta de Dermatologia</option>
                                                    <option value="Neurologia">Consulta de Neurologia</option>
                                                    <option value="Oftalmologia">Consulta de Oftalmologia</option>
                                                    <option value="Psiquiatria">Consulta de Psiquiatria</option>
                                                    <option value="Outros">Outros</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="form-group row">
                                            <label for="txtstatus"
                                                class="col-sm-2 col-form-label font-weight-bold">Status</label>
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
                                            <label for="txtpatient"
                                                class="col-sm-2 col-form-label font-weight-bold">Paciente</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="txtpatient" required>
                                                    <option value="">Carregando pacientes...</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Médico -->
                                        <div class="form-group row">
                                            <label for="txtdoctor"
                                                class="col-sm-2 col-form-label font-weight-bold">Médico</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="txtdoctor" required>
                                                    <option value="">Carregando médicos...</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Botões -->
                                        <div class="form-group row mt-4">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-success px-4">
                                                    <i class="feather icon-save"></i> Registar Consulta
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

<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Carregar pacientes
    fetch("routes/patientRoutes.php")
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById("txtpatient");
            select.innerHTML = '<option value="">Selecione um Paciente</option>';
            if (data.status === "success" && data.data.length > 0) {
                data.data.forEach(p => {
                    const opt = document.createElement("option");
                    opt.value = p.id;
                    opt.textContent = p.name;
                    select.appendChild(opt);
                });
            }
        });

    // Carregar médicos
    fetch("routes/employeeRoutes.php")
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById("txtdoctor");
            select.innerHTML = '<option value="">Selecione um Médico</option>';
            if (data.status === "success" && data.data.length > 0) {
                data.data.forEach(d => {
                    const opt = document.createElement("option");
                    opt.value = d.id;
                    opt.textContent = d.name;
                    select.appendChild(opt);
                });
            }
        });
});

// Submeter consulta
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
                swal("Sucesso!", data.message, "success")
                    .then(() => window.location.href = "link.php?route=7");
            } else {
                swal("Erro!", data.message, "error");
            }
        })
        .catch(err => {
            console.error("Erro ao enviar a requisição:", err);
            swal("Erro!", "Falha ao tentar enviar os dados.", "error");
        });
}

// Gerar PDF
function gerarPDFConsulta() {
    const {
        jsPDF
    } = window.jspdf;
    const doc = new jsPDF();

    const paciente = document.getElementById("txtpatient").selectedOptions[0]?.textContent || "—";
    const medico = document.getElementById("txtdoctor").selectedOptions[0]?.textContent || "—";
    const data = document.getElementById("txtdate").value || "—";
    const hora = document.getElementById("txttime").value || "—";
    const tipo = document.getElementById("txttype").value || "—";

    doc.setFontSize(16);
    doc.text("Relatório de Consulta Médica", 70, 20);

    doc.setFontSize(12);
    doc.text(`📅 Data: ${data}`, 20, 40);
    doc.text(`🕒 Hora: ${hora}`, 20, 50);
    doc.text(`👤 Paciente: ${paciente}`, 20, 60);
    doc.text(`⚕️ Médico: ${medico}`, 20, 70);
    doc.text(`💬 Tipo de Consulta: ${tipo}`, 20, 80);

    doc.line(20, 90, 190, 90);
    doc.text("Assinatura do Médico: ___________________________", 20, 110);

    doc.save(`Consulta_${paciente}_${data}.pdf`);
}
</script>