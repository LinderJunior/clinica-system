<?php
include_once __DIR__ . './../../src/components/header.php';
$doctorId = $_GET['id'] ?? null;
?>

<div class="pcoded-content">
    <div class="page-header card py-2 px-3 border-0 shadow-sm">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary fw-semibold" style="font-size: 1.25rem;">Dashboard do Médico</h5>
                <a href="link.php?route=9" class="btn btn-outline-secondary btn-sm">
                    <i class="icofont icofont-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <!-- Cards Estatísticos -->
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <div class="card bg-primary text-white shadow-sm border-0">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 id="total-consults">--</h4>
                                        <p class="mb-0">Consultas Totais</p>
                                    </div>
                                    <i class="icofont icofont-stethoscope" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card bg-success text-white shadow-sm border-0">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 id="completed">--</h4>
                                        <p class="mb-0">Concluídas</p>
                                    </div>
                                    <i class="icofont icofont-check-circled" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card bg-warning text-white shadow-sm border-0">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 id="pending">--</h4>
                                        <p class="mb-0">Pendentes</p>
                                    </div>
                                    <i class="icofont icofont-clock-time" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card bg-danger text-white shadow-sm border-0">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 id="canceled">--</h4>
                                        <p class="mb-0">Canceladas</p>
                                    </div>
                                    <i class="icofont icofont-close-circled" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card bg-info text-white shadow-sm border-0">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 id="month-total">--</h4>
                                        <p class="mb-0">Consultas do Mês</p>
                                    </div>
                                    <i class="icofont icofont-calendar"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card bg-secondary text-white shadow-sm border-0">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 id="week-total">--</h4>
                                        <p class="mb-0">Consultas da Semana</p>
                                    </div>
                                    <i class="icofont icofont-clock-alt"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 mt-3">
                            <div class="card bg-dark text-white shadow-sm border-0">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 id="faturamento">--</h4>
                                        <p class="mb-0">Faturamento (MZN)</p>
                                    </div>
                                    <i class="icofont icofont-money"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráficos -->
                    <div class="row mb-4">
                        <div class="col-md-6 d-flex">
                            <div class="card border-0 shadow-sm w-100">
                                <div class="card-header bg-light fw-semibold">Consultas por Mês (Bar)</div>
                                <div class="card-body">
                                    <canvas id="consultsPerMonthBar"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex">
                            <div class="card border-0 shadow-sm w-100">
                                <div class="card-header bg-light fw-semibold">Consultas por Mês (Linha)</div>
                                <div class="card-body">
                                    <canvas id="consultsPerMonthLine"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold">Consultas Recentes</h6>
                            <button class="btn btn-outline-primary btn-sm" id="refresh-btn">
                                <i class="icofont icofont-refresh"></i> Atualizar
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="consultTable" class="table table-striped table-hover nowrap w-100">
                                    <thead class="table-light">
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Data</th>
                                            <th>Hora</th>
                                            <th>Tipo</th>
                                            <th>Paciente</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>







<style>
/* BOTOES MARCAR CONSULTA E VER CONSULTA */

.btn {
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    padding: 10px 16px;
    border: none;
    cursor: pointer;
}

/* Padronizar tamanho dos botões personalizados */
.btn-ver,
.btn-marcar {
    min-width: 130px;
    /* define uma largura mínima igual aos outros botões */
    height: 38px;
    /* altura proporcional à classe .btn-sm */
    font-size: 14px;
    /* texto uniforme */
    font-weight: 500;
    border-radius: 6px;
    /* bordas suaves como os outros */
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Botão MARCAR CONSULTA */
.btn-marcar {
    background: linear-gradient(135deg, #28a745, #34d058);
    color: white;
    box-shadow: 0 4px 10px rgba(40, 167, 69, 0.4);
}

.btn-marcar:hover {
    background: linear-gradient(135deg, #218838, #2ebf4f);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(40, 167, 69, 0.5);
}

/* Botão VER CONSULTA */
.btn-ver {
    background: linear-gradient(135deg, #007bff, #3399ff);
    color: white;
    box-shadow: 0 4px 10px rgba(0, 123, 255, 0.4);
}

.btn-ver:hover {
    background: linear-gradient(135deg, #0069d9, #2a8cff);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 123, 255, 0.5);
}

/* Ícones */
.btn i {
    margin-right: 6px;
    font-size: 15px;
}

/* Espaçamento entre botões */
.action {
    margin-right: 10px;
}
</style>







</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const doctorId = <?= json_encode($doctorId) ?>;
let consultsTable;
let chartMonthBar, chartMonthLine;

async function loadDoctorDashboard() {
    try {
        const res = await fetch("http://localhost/clinica-system/routes/index.php?route=consults", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                action: "dashboard_doctor",
                doctor_id: parseInt(doctorId)
            })
        });

        const data = await res.json();
        if (data.status !== "success") {
            alert("Erro ao carregar dashboard!");
            return;
        }

        const d = data.data;

        // Atualiza cards
        $("#total-consults").text(d.total_consults);
        $("#completed").text(d.completed);
        $("#pending").text(d.pending);
        $("#canceled").text(d.canceled);
        $("#month-total").text(d.month_total);
        $("#week-total").text(d.week_total);
        $("#faturamento").text(d.faturamento.toLocaleString());

        // Tabela
        if (consultsTable) consultsTable.clear().rows.add(d.consults).draw();
        else initConsultTable(d.consults);

        // Dados gráficos
        const monthsLabels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        const monthsData = Array(12).fill(0);
        d.consults.forEach(c => {
            const month = new Date(c.date).getMonth();
            if (!isNaN(month)) monthsData[month]++;
        });

        renderCharts(monthsLabels, monthsData);

    } catch (err) {
        console.error(err);
        alert("Erro de conexão com o servidor!");
    }
}




// DataTable
function initConsultTable(consults) {
    consultsTable = $('#consultTable').DataTable({
        responsive: true,
        data: consults,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        columns: [{
                data: null,
                render: (d, t, r, m) => m.row + 1,
                className: "text-center"
            },
            {
                data: "date"
            },
            {
                data: "time"
            },
            {
                data: "type"
            },
            {
                data: "patient_name"
            },
            {
                data: "status",
                className: "text-center",
                render: status => {
                    const badges = {
                        0: '<span class="badge bg-warning text-dark">Pendente</span>',
                        1: '<span class="badge bg-success">Concluída</span>',
                        2: '<span class="badge bg-danger">Cancelada</span>'
                    };
                    return badges[status] || '<span class="badge bg-secondary">Desconhecido</span>';
                }
            },
            {
                data: null,
                orderable: false,
                className: "text-center",
                defaultContent: `
                    <button class="btn btn-sm btn-ver action" data-action="manage" title="Ver Consultas">
                        <i class="icofont icofont-eye"></i>Detalhes da consulta
                    </button>
                `
            }
        ],
        language: {
            lengthMenu: "Mostrar _MENU_ consultas",
            zeroRecords: "Nenhuma consulta encontrada",
            info: "Mostrando _START_ a _END_ de _TOTAL_ consultas",
            infoEmpty: "Sem dados disponíveis",
            search: "Pesquisar:",
            paginate: {
                first: "Primeiro",
                last: "Último",
                next: "Próximo",
                previous: "Anterior"
            }
        }
    });

    // Ação do botão
    $('#consultTable tbody').on('click', 'button.action', function() {
        const action = $(this).data('action');
        const data = consultsTable.row($(this).parents('tr')).data();
        if (action === "manage") {
            const consultId = data.id;
            window.location.href = `link.php?route=17&id=${consultId}`;
        }
    });
}





function renderCharts(labels, data) {
    if (chartMonthBar) chartMonthBar.destroy();
    if (chartMonthLine) chartMonthLine.destroy();

    const ctxBar = document.getElementById('consultsPerMonthBar');
    chartMonthBar = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Consultas',
                data: data,
                backgroundColor: '#007bff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    const ctxLine = document.getElementById('consultsPerMonthLine');
    chartMonthLine = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Consultas',
                data: data,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40,167,69,0.2)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}

$(document).ready(() => {
    loadDoctorDashboard();
    $('#refresh-btn').click(loadDoctorDashboard);
});
</script>