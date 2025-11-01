<?php 
include_once __DIR__ . './../../src/components/header.php';
$patientId = isset($_GET['patient_id']) ? intval($_GET['patient_id']) : null;
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
                                <div class="card-block p-4">

                                    <?php if ($patientId): ?>
                                    <!-- Alerta de paciente pré-selecionado -->
                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="feather icon-user-check mr-2"></i>
                                        <span>O paciente foi pré-selecionado automaticamente. Alteração não é
                                            permitida.</span>
                                    </div>
                                    <?php endif; ?>

                                    <!-- FORMULÁRIO -->
                                    <form id="consultaForm" onsubmit="submitConsulta(event)">

                                        <!-- Data -->
                                        <div class="form-group row">
                                            <label for="txtdate"
                                                class="col-sm-2 col-form-label font-weight-bold">Data</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txtdate"
                                                    placeholder="dd/mm/yyyy" required>
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
                                                    <option value="Triagem">TRIAGEM</option>
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
                                                class="col-sm-2 col-form-label font-weight-bold">Clínico</label>
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
                                    <!-- FIM FORM -->
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

<script>
document.addEventListener("DOMContentLoaded", () => {
    const patientId = <?= $patientId ? $patientId : 'null' ?>;
    const patientSelect = document.getElementById("txtpatient");

    // --- Carregar Pacientes ---
    fetch("routes/patientRoutes.php")
        .then(res => res.json())
        .then(data => {
            patientSelect.innerHTML = '<option value="">Selecione um Paciente</option>';
            if (data.status === "success" && Array.isArray(data.data)) {
                data.data.forEach(p => {
                    const opt = document.createElement("option");
                    opt.value = p.id;
                    opt.textContent = p.name || p.nome;
                    patientSelect.appendChild(opt);
                });

                // Caso tenha vindo com patient_id
                if (patientId) {
                    patientSelect.value = patientId;
                    patientSelect.disabled = true; // bloqueia para evitar troca
                }

                // Deixar o nome do paciente selecionado em negrito
                const selectedOption = patientSelect.options[patientSelect.selectedIndex];
                if (selectedOption) {
                    selectedOption.style.fontWeight = "bold";
                    selectedOption.style.color = "#007bff"; // opcional: azul para destaque
                }




            } else {
                patientSelect.innerHTML = '<option value="">Nenhum paciente encontrado</option>';
            }
        })
        .catch(err => console.error("Erro ao carregar pacientes:", err));

    // --- Carregar Médicos ---
    fetch("routes/employeeRoutes.php?doctors=true")
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById("txtdoctor");
            select.innerHTML = '<option value="">Selecione um Médico</option>';
            if (data.status === "success" && Array.isArray(data.data)) {
                data.data.forEach(m => {
                    const opt = document.createElement("option");
                    opt.value = m.id;
                    opt.textContent = m.name || m.nome;
                    select.appendChild(opt);
                });
            } else {
                select.innerHTML = '<option value="">Nenhum médico encontrado</option>';
            }
        })
        .catch(err => console.error("Erro ao carregar médicos:", err));
});

// --- Submissão ---
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
                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: data.message || "Consulta registada com sucesso!",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "link.php?route=7";
                });
            } else {
                Swal.fire("Erro!", data.message, "error");
            }
        })
        .catch(err => {
            console.error("Erro ao enviar a requisição:", err);
            Swal.fire("Erro!", "Falha ao tentar enviar os dados.", "error");
        });
}

// --- Gerar PDF ---
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







<!-- Flatpickr Date Picker -->

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Se flatpickr ainda não estiver definido, espera 200ms e tenta novamente (até 5x)
    function waitForFlatpickr(attemptsLeft = 5) {
        if (window.flatpickr) {
            initFlatpickr();
        } else if (attemptsLeft > 0) {
            setTimeout(() => waitForFlatpickr(attemptsLeft - 1), 200);
        } else {
            // fallback: carrega dinamicamente
            loadFlatpickrDynamically().then(initFlatpickr).catch(err => {
                console.error("Não foi possível carregar o flatpickr:", err);
            });
        }
    }

    function loadFlatpickrDynamically() {
        return new Promise((resolve, reject) => {
            const s = document.createElement('script');
            s.src = "https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js";
            s.onload = () => {
                const s2 = document.createElement('script');
                s2.src = "https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js";
                s2.onload = resolve;
                s2.onerror = reject;
                document.body.appendChild(s2);
            };
            s.onerror = reject;
            document.body.appendChild(s);
        });
    }

    function initFlatpickr() {
        // garante que o campo existe
        const el = document.getElementById("txtdate");
        if (!el) return;

        flatpickr(el, {
            dateFormat: "Y-m-d", // formato interno (recomendado ISO para backend)
            altInput: true,
            altFormat: "d/m/Y", // formato visível para o utilizador (dd/mm/yyyy)
            locale: "pt", // pt (usa o ficheiro l10n)
            maxDate: "today",
            disableMobile: true
        });

        // Se quiseres forçar valor placeholder já formatado:
        // el.placeholder = "dd/mm/yyyy";
    }

    waitForFlatpickr();
});
</script>