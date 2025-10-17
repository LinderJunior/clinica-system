<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">

    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Progresso do Cliente
                </h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-danger btn-sm d-flex align-items-center shadow-sm" id="generate-pdf" style="font-size: 0.9rem; padding: 0.35rem 0.7rem; display: none;">
                        <i class="icofont icofont-file-pdf mr-1" style="font-size: 1rem;"></i>
                        Gerar PDF
                    </button>
                    <a href="link.php?route=23" class="btn btn-secondary btn-sm d-flex align-items-center shadow-sm" style="font-size: 0.9rem; padding: 0.35rem 0.7rem;">
                        <i class="icofont icofont-arrow-left mr-1" style="font-size: 1rem;"></i>
                        Voltar à Lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    
                    <!-- Filtro de Cliente -->
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h6 class="text-secondary mb-0 text-uppercase">
                                        <i class="icofont icofont-filter mr-2"></i>
                                        Filtrar por Cliente
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="client-filter">Selecione o Cliente</label>
                                                <select class="form-control" id="client-filter">
                                                    <option value="">Selecione um cliente para ver o progresso</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="period-filter">Período</label>
                                                <select class="form-control" id="period-filter">
                                                    <option value="all">Todos os registros</option>
                                                    <option value="30">Últimos 30 dias</option>
                                                    <option value="90">Últimos 3 meses</option>
                                                    <option value="180">Últimos 6 meses</option>
                                                    <option value="365">Último ano</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informações do Cliente -->
                    <div class="row mb-4" id="client-info" style="display: none;">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">
                                        <i class="icofont icofont-user mr-2"></i>
                                        Informações do Cliente
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p><strong>Nome:</strong> <span id="client-name">-</span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Total de Registros:</strong> <span id="total-records">-</span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Último Registro:</strong> <span id="last-record">-</span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Variação de Peso:</strong> <span id="weight-variation">-</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estatísticas -->
                    <div class="row mb-4" id="stats-cards" style="display: none;">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0" id="current-weight">-</h4>
                                            <p class="mb-0">Peso Atual (kg)</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="icofont icofont-weight-scale" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0" id="current-bmi">-</h4>
                                            <p class="mb-0">IMC Atual</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="icofont icofont-heart-beat" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0" id="min-weight">-</h4>
                                            <p class="mb-0">Peso Mínimo (kg)</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="icofont icofont-arrow-down" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0" id="max-weight">-</h4>
                                            <p class="mb-0">Peso Máximo (kg)</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="icofont icofont-arrow-up" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráfico de Progresso -->
                    <div class="row mb-4" id="chart-section" style="display: none;">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h6 class="text-secondary mb-0 text-uppercase">
                                        <i class="icofont icofont-chart-line mr-2"></i>
                                        Evolução do Peso
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="weightChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela de Registros -->
                    <div class="row" id="records-table" style="display: none;">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h6 class="text-secondary mb-0 text-uppercase">
                                        <i class="icofont icofont-table mr-2"></i>
                                        Histórico de Registros
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="progressTable" class="table table-sm table-striped table-hover align-middle" style="width:100%">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Altura (m)</th>
                                                    <th>Peso (kg)</th>
                                                    <th>IMC</th>
                                                    <th>Classificação</th>
                                                    <th>Variação</th>
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
    </div>
</div>

<style>
.card {
    border-radius: 10px;
}

.table {
    font-size: 0.9rem;
    border-color: #dee2e6;
}

.table thead th {
    background-color: #f9fafb;
    color: #495057;
    font-weight: 600;
    text-align: center;
    padding: 8px 10px;
    border-bottom: 2px solid #e9ecef;
}

.table tbody td {
    vertical-align: middle;
    text-align: center;
    padding: 6px 10px;
}

.badge-positive {
    background-color: #28a745;
}

.badge-negative {
    background-color: #dc3545;
}

.badge-neutral {
    background-color: #6c757d;
}

.badge-underweight {
    background-color: #6c757d;
}

.badge-normal {
    background-color: #28a745;
}

.badge-overweight {
    background-color: #ffc107;
    color: #212529;
}

.badge-obese1 {
    background-color: #fd7e14;
}

.badge-obese2 {
    background-color: #dc3545;
}

.badge-obese3 {
    background-color: #6f42c1;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    let weightChart = null;
    let progressTable = null;

    // Inicializar DataTable
    progressTable = $('#progressTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        order: [[0, 'desc']], // Ordenar por data (mais recente primeiro)
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "Nenhum registro encontrado",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
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

    // Carregar clientes
    function loadClients() {
        fetch("routes/index.php?route=patients")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    const select = $('#client-filter');
                    select.empty().append('<option value="">Selecione um cliente para ver o progresso</option>');
                    data.data.forEach(patient => {
                        select.append(`<option value="${patient.id}">${patient.name}</option>`);
                    });
                }
            }).catch(err => console.error('Erro ao carregar clientes:', err));
    }

    // Função para obter badge da classificação
    function getClassificationBadge(classification) {
        const badges = {
            'Abaixo do peso': 'badge-underweight',
            'Peso normal': 'badge-normal',
            'Sobrepeso': 'badge-overweight',
            'Obesidade grau I': 'badge-obese1',
            'Obesidade grau II': 'badge-obese2',
            'Obesidade grau III': 'badge-obese3'
        };
        
        const badgeClass = badges[classification] || 'badge-secondary';
        return `<span class="badge ${badgeClass}">${classification}</span>`;
    }

    // Função para obter badge de variação
    function getVariationBadge(variation) {
        if (variation > 0) {
            return `<span class="badge badge-negative">+${variation.toFixed(1)} kg</span>`;
        } else if (variation < 0) {
            return `<span class="badge badge-positive">${variation.toFixed(1)} kg</span>`;
        } else {
            return `<span class="badge badge-neutral">0.0 kg</span>`;
        }
    }

    // Carregar progresso do cliente
    function loadClientProgress(clientId, period = 'all') {
        if (!clientId) {
            hideAllSections();
            return;
        }

        let url = `routes/index.php?route=client-weights&client_id=${clientId}`;
        
        // Adicionar filtro de período se necessário
        if (period !== 'all') {
            const endDate = new Date();
            const startDate = new Date();
            startDate.setDate(startDate.getDate() - parseInt(period));
            
            url += `&start_date=${startDate.toISOString().split('T')[0]}&end_date=${endDate.toISOString().split('T')[0]}`;
        }

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    displayClientProgress(data.data);
                } else {
                    hideAllSections();
                    swal("Info", "Nenhum registro encontrado para este cliente.", "info");
                }
            }).catch(err => {
                console.error('Erro ao carregar progresso:', err);
                hideAllSections();
            });
    }

    // Exibir progresso do cliente
    function displayClientProgress(records) {
        if (records.length === 0) {
            hideAllSections();
            return;
        }

        // Ordenar registros por data
        records.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));

        // Mostrar seções
        showAllSections();

        // Atualizar informações do cliente
        updateClientInfo(records);

        // Atualizar estatísticas
        updateStats(records);

        // Atualizar gráfico
        updateChart(records);

        // Atualizar tabela
        updateTable(records);
    }

    // Atualizar informações do cliente
    function updateClientInfo(records) {
        const firstRecord = records[0];
        const lastRecord = records[records.length - 1];
        const weightDiff = lastRecord.weight - firstRecord.weight;

        $('#client-name').text(firstRecord.client_name);
        $('#total-records').text(records.length);
        $('#last-record').text(new Date(lastRecord.created_at).toLocaleDateString('pt-BR'));
        
        const variationText = weightDiff > 0 ? `+${weightDiff.toFixed(1)} kg` : `${weightDiff.toFixed(1)} kg`;
        const variationClass = weightDiff > 0 ? 'text-danger' : weightDiff < 0 ? 'text-success' : 'text-muted';
        $('#weight-variation').html(`<span class="${variationClass}">${variationText}</span>`);
    }

    // Atualizar estatísticas
    function updateStats(records) {
        const weights = records.map(r => parseFloat(r.weight));
        const currentRecord = records[records.length - 1];

        $('#current-weight').text(parseFloat(currentRecord.weight).toFixed(1));
        $('#current-bmi').text(parseFloat(currentRecord.bmi).toFixed(1));
        $('#min-weight').text(Math.min(...weights).toFixed(1));
        $('#max-weight').text(Math.max(...weights).toFixed(1));
    }

    // Atualizar gráfico
    function updateChart(records) {
        const ctx = document.getElementById('weightChart').getContext('2d');
        
        if (weightChart) {
            weightChart.destroy();
        }

        const labels = records.map(r => new Date(r.created_at).toLocaleDateString('pt-BR'));
        const weights = records.map(r => parseFloat(r.weight));
        const bmis = records.map(r => parseFloat(r.bmi));

        weightChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Peso (kg)',
                    data: weights,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1,
                    yAxisID: 'y'
                }, {
                    label: 'IMC',
                    data: bmis,
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.1,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Data'
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Peso (kg)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'IMC'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                }
            }
        });
    }

    // Atualizar tabela
    function updateTable(records) {
        progressTable.clear();
        
        records.forEach((record, index) => {
            const formattedDate = new Date(record.created_at).toLocaleDateString('pt-BR');
            const variation = index > 0 ? parseFloat(record.weight) - parseFloat(records[index - 1].weight) : 0;
            
            progressTable.row.add([
                formattedDate,
                parseFloat(record.height).toFixed(2),
                parseFloat(record.weight).toFixed(1),
                parseFloat(record.bmi).toFixed(1),
                getClassificationBadge(record.classification),
                index > 0 ? getVariationBadge(variation) : '-'
            ]);
        });
        
        progressTable.draw();
    }

    // Mostrar todas as seções
    function showAllSections() {
        $('#client-info').show();
        $('#stats-cards').show();
        $('#chart-section').show();
        $('#records-table').show();
        $('#generate-pdf').show();
    }

    // Esconder todas as seções
    function hideAllSections() {
        $('#client-info').hide();
        $('#stats-cards').hide();
        $('#chart-section').hide();
        $('#records-table').hide();
        $('#generate-pdf').hide();
    }

    // Event listeners
    $('#client-filter').on('change', function() {
        const clientId = $(this).val();
        const period = $('#period-filter').val();
        loadClientProgress(clientId, period);
    });

    $('#period-filter').on('change', function() {
        const clientId = $('#client-filter').val();
        const period = $(this).val();
        loadClientProgress(clientId, period);
    });

    // Gerar PDF
    $('#generate-pdf').on('click', function() {
        const clientId = $('#client-filter').val();
        const period = $('#period-filter').val();
        
        if (!clientId) {
            swal("Erro!", "Selecione um cliente primeiro.", "error");
            return;
        }

        // Mostrar loading
        const btn = $(this);
        const originalText = btn.html();
        btn.prop('disabled', true).html('<i class="icofont icofont-spinner-alt-3 icofont-spin mr-1"></i> Gerando...');

        // Construir URL para o PDF
        let pdfUrl = `routes/client-weight-pdf.php?client_id=${clientId}`;
        if (period !== 'all') {
            pdfUrl += `&period=${period}`;
        }

        // Abrir PDF em nova aba
        window.open(pdfUrl, '_blank');

        // Restaurar botão após um tempo
        setTimeout(() => {
            btn.prop('disabled', false).html(originalText);
        }, 2000);
    });

    // Inicializar
    loadClients();
    hideAllSections();
});
</script>

<?php include_once __DIR__ . './../../src/components/footer.php'; ?>
