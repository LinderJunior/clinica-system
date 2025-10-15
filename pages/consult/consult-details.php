<?php
include_once __DIR__ . './../../src/components/header.php';
$id = $_GET['id'] ?? null;
?>

<div class="pcoded-content">
    <div class="page-header card border-0 shadow-sm">
        <div class="row align-items-end">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold">Gestão da Consulta Nº <?= htmlspecialchars($id) ?></h5>
                <a href="link.php?route=9" class="btn btn-outline-secondary btn-sm">
                    <i class="icofont icofont-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content mt-3">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <!-- Detalhes da Consulta -->
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0 fw-semibold">Detalhes da Consulta</h6>
                        </div>
                        <div class="card-body" id="consultDetails">
                            <p class="text-muted mb-0">Carregando detalhes da consulta...</p>
                        </div>
                    </div>

                    <!-- Diagnósticos -->
                    <div class="card mb-4 shadow-sm border-0">
                        <div
                            class="card-header bg-info text-white d-flex justify-content-between align-items-center py-2">
                            <h6 class="mb-0 fw-semibold">Diagnósticos</h6>
                            <button class="btn btn-light btn-sm" id="btnAddDiagnosis" data-toggle="modal"
                                data-target="#modalAddDiagnosis">
                                <i class="icofont icofont-plus"></i> Novo Diagnóstico
                            </button>
                        </div>
                        <div class="card-body" id="diagnosisList">
                            <p class="text-muted mb-0">Carregando diagnósticos...</p>
                        </div>
                    </div>

                    <!-- Receitas -->
                    <div class="card mb-4 shadow-sm border-0">
                        <div
                            class="card-header bg-success text-white d-flex justify-content-between align-items-center py-2">
                            <h6 class="mb-0 fw-semibold">Receitas Médicas</h6>
                            <button class="btn btn-light btn-sm" id="btnAddRecipe">
                                <i class="icofont icofont-plus"></i> Nova Receita
                            </button>
                        </div>
                        <div class="card-body" id="recipeList">
                            <p class="text-muted mb-0">Carregando receitas...</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Novo Diagnóstico -->
<div class="modal fade" id="modalAddDiagnosis" tabindex="-1" role="dialog" aria-labelledby="modalAddDiagnosisLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalAddDiagnosisLabel">Registrar Novo Diagnóstico</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="diagnosticForm">

                    <div class="form-group row">
                        <label for="txtdetails" class="col-sm-3 col-form-label">Detalhes do Diagnóstico</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="txtdetails" placeholder="Descreva o diagnóstico"
                                required></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="txtfile" class="col-sm-3 col-form-label">Ficheiro (Exame / Relatório)</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txtfile" placeholder="exame_resultado.pdf"
                                required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="txtdoctor" class="col-sm-3 col-form-label">Médico Responsável</label>
                        <div class="col-sm-9">
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

                </form>
            </div>

            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-info" id="btnSaveDiagnosis">
                    <i class="feather icon-save"></i> Guardar Diagnóstico
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Estilo Profissional -->
<style>
/* Layout geral */
body {
    background-color: #f7f9fb;
}

/* Cabeçalhos */
.page-header.card {
    background-color: #ffffff;
    border-left: 4px solid #007bff;
    padding: 15px 20px;
}

/* Cartões */
.card {
    border-radius: 8px;
}

.card-header {
    font-weight: 600;
    font-size: 0.95rem;
}

.card-body {
    background-color: #fff;
    font-size: 0.95rem;
}



/* Tabelas */
.table {
    border-collapse: collapse !important;
    width: 100%;
    margin-bottom: 0;
}

.table th,
.table td {
    padding: 0.55rem 0.75rem;
    vertical-align: middle !important;
}

.table th {
    background-color: #f1f4f8;
    font-weight: 600;
    color: #333;
    border-bottom: 1px solid #dee2e6;
}

.table td {
    border-top: 1px solid #e9ecef;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fc;
}


.table-actions .btn {
    padding: 0.25rem 0.45rem;
    font-size: 0.8rem;
    border-radius: 4px;
    box-shadow: none;
}

/* Botões */
.btn {
    border-radius: 6px;
    transition: all 0.2s ease-in-out;
}

.btn-light:hover {
    background-color: #eef2f6;
}

/* Modal */
.modal-content {
    border-radius: 8px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

/* Tipografia */
.text-muted {
    font-size: 0.9rem;
}



/* ===== Estilo específico: Detalhes da Consulta ===== */
#consultDetails .card {
    background: #ffffff;
    border-radius: 10px;
    border: 1px solid #e0e6ed;
}

#consultDetails .card-body {
    font-size: 0.95rem;
    line-height: 1.45;
}

#consultDetails .fw-semibold {
    font-weight: 600;
    color: #495057;
}

#consultDetails .row.g-2 .col-12 {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#consultDetails span {
    display: inline-block;
    text-align: right;
    white-space: nowrap;
}

#consultDetails .badge {
    font-size: 0.8rem;
    padding: 0.35em 0.55em;
}

#consultDetails .btn-sm {
    padding: 0.3rem 0.6rem;
    border-radius: 5px;
    transition: all 0.2s ease-in-out;
}

#consultDetails .btn-sm:hover {
    background-color: #eef2f6;
}

/* Espaçamento fino entre colunas */
#consultDetails .row.g-3 {
    --bs-gutter-x: 1.25rem;
}

/* Ajuste responsivo */
@media (max-width: 768px) {
    #consultDetails .row.g-2 .col-12 {
        flex-direction: column;
        align-items: flex-start;
    }

    #consultDetails span {
        text-align: left;
    }

    #consultDetails .text-end {
        text-align: left !important;
    }
}
</style>

<script>
const consultId = <?= json_encode($id) ?>;

$(document).ready(() => {

    // Detalhes da Consulta
    // Detalhes da Consulta (layout profissional e alinhado)
    fetch(`routes/consultRoutes.php?id=${consultId}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === "success" && data.data) {
                const c = data.data;
                $('#consultDetails').html(`
                <div class="card shadow-sm mb-3 border-0">
                    <div class="card-body p-3">
                        <div class="row g-3 align-items-center">
                            <!-- Lado Esquerdo -->
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-12 d-flex justify-content-between">
                                        <span class="text-muted fw-semibold">Data:</span>
                                        <span>${c.date ?? '—'}</span>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                        <span class="text-muted fw-semibold">Paciente:</span>
                                        <span>${c.patient_name ?? '—'}</span>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                        <span class="text-muted fw-semibold">Tipo:</span>
                                        <span>${c.type ?? '—'}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Lado Direito -->
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-12 d-flex justify-content-between">
                                        <span class="text-muted fw-semibold">Hora:</span>
                                        <span>${c.time ?? '—'}</span>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                        <span class="text-muted fw-semibold">Status:</span>
                                        <span>${c.status == 1 ? '<span class="badge bg-success">Concluída</span>' : '<span class="badge bg-warning text-dark">Pendente</span>'}</span>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                        <span class="text-muted fw-semibold">Médico:</span>
                                        <span>${c.doctor_name ?? '—'}</span>
                                    </div>
                                    <div class="col-12 text-end mt-2">
                                        <button class="btn btn-outline-primary btn-sm">
                                            <i class="icofont icofont-download"></i> Baixar Consulta
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `);
            } else {
                $('#consultDetails').html('<p class="text-muted">Detalhes não encontrados.</p>');
            }
        });



    // Diagnósticos
    loadDiagnoses();

    function loadDiagnoses() {
        fetch(`routes/diagnosisRoutes.php?consult_id=${consultId}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && data.data.length > 0) {
                    let html = `
                    <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="text-center">
                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:45%">Detalhes</th>
                                <th style="width:15%">Ficheiro</th>
                                <th style="width:20%">Médico</th>
                                <th style="width:20%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    data.data.forEach(d => {
                        html += `
                        <tr>
                            <td class="text-center">${d.id}</td>
                            <td>${d.details ?? '—'}</td>
                            <td class="text-center">
                                ${d.file ? `<a href="${d.file}" target="_blank" class="btn btn-light btn-sm border"><i class="icofont icofont-file-alt text-info"></i> Ver</a>` : '—'}
                            </td>
                            <td>${d.doctor_name ?? '—'}</td>
                            <td class="text-center table-actions">
                                <button class="btn btn-light btn-sm border" title="Editar">
                                    <i class="icofont icofont-ui-edit text-primary"></i>
                                </button>
                                <button class="btn btn-light btn-sm border" title="Imprimir">
                                    <i class="icofont icofont-print text-success"></i>
                                </button>
                                <button class="btn btn-light btn-sm border" title="Eliminar">
                                    <i class="icofont icofont-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>`;
                    });
                    html += `</tbody></table></div>`;
                    $('#diagnosisList').html(html);
                } else {
                    $('#diagnosisList').html('<p class="text-muted">Nenhum diagnóstico registrado.</p>');
                }
            });
    }



    // Receitas
    fetch(`routes/recipeRoutes.php?consult_id=${consultId}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === "success" && data.data.length > 0) {
                let html = `
                    <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead><tr><th>Medicamento</th><th>Quantidade</th><th>Dosagem</th></tr></thead>
                        <tbody>`;
                data.data.forEach(r => {
                    html +=
                        `<tr><td>${r.medication_name}</td><td>${r.qty}</td><td>${r.dosage}</td></tr>`;
                });
                html += `</tbody></table></div>`;
                $('#recipeList').html(html);
            } else {
                $('#recipeList').html('<p class="text-muted">Nenhuma receita registrada.</p>');
            }
        });

    // Submeter Diagnóstico
    $('#btnSaveDiagnosis').click(() => {
        const formData = {
            action: "add",
            details: $('#txtdetails').val().trim(),
            file: $('#txtfile').val().trim(),
            consult_id: Number(consultId),
            doctor_id: Number($('#txtdoctor').val())
        };

        if (!formData.details || !formData.file || !formData.doctor_id) {
            alert('Por favor, preencha todos os campos antes de continuar.');
            return;
        }

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
                    $('#modalAddDiagnosis').modal('hide');
                    $('#diagnosticForm')[0].reset();
                    loadDiagnoses();
                } else {
                    alert("Erro: " + data.message);
                }
            })
            .catch(err => console.error("Erro ao registrar diagnóstico:", err));
    });

    // Nova Receita
    $('#btnAddRecipe').click(() => window.location.href = `recipeForm.php?consult_id=${consultId}`);
});
</script>