<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">

    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Dashboard do Médico
                </h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-sm d-flex align-items-center shadow-sm" id="export-excel"
                        style="font-size: 0.9rem; padding: 0.35rem 0.7rem;">
                        <i class="icofont icofont-file-excel mr-1" style="font-size: 1rem;"></i>
                        Exportar Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <!-- Cards de Resumo -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0" id="total-consultas">-</h4>
                                            <p class="mb-0">Consultas Totais</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="icofont icofont-stethoscope" style="font-size: 2rem;"></i>
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
                                            <h4 class="mb-0" id="consultas-realizadas">-</h4>
                                            <p class="mb-0">Consultas Realizadas</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="icofont icofont-check-circled" style="font-size: 2rem;"></i>
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
                                            <h4 class="mb-0" id="faturamento">-</h4>
                                            <p class="mb-0">Faturamento (MZN)</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="icofont icofont-money" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0" id="salario-mes">-</h4>
                                            <p class="mb-0">Salário do Mês (MZN)</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="icofont icofont-ui-user" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h6 class="text-secondary mb-0 text-uppercase">
                                        <i class="icofont icofont-filter mr-2"></i>
                                        Filtros
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="month-filter">Filtrar por Mês (AAAA-MM)</label>
                                                <input type="month" class="form-control" id="month-filter">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="status-filter">Filtrar por Status</label>
                                                <select class="form-control" id="status-filter">
                                                    <option value="all">Todos</option>
                                                    <option value="scheduled">Agendadas</option>
                                                    <option value="done">Realizadas</option>
                                                    <option value="canceled">Canceladas</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <button class="btn btn-primary mr-2" id="apply-filters">
                                                <i class="icofont icofont-search mr-1"></i>
                                                Aplicar Filtros
                                            </button>
                                            <button class="btn btn-secondary" id="clear-filters">
                                                <i class="icofont icofont-refresh mr-1"></i>
                                                Limpar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela de Consultas -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h6 class="text-secondary mb-0 text-uppercase">
                                        <i class="icofont icofont-table mr-2"></i>
                                        Lista de Consultas
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="consultasTable"
                                            class="table table-sm table-striped table-hover align-middle"
                                            style="width:100%">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Paciente</th>
                                                    <th>Data</th>
                                                    <th>Hora</th>
                                                    <th>Valor (MZN)</th>
                                                    <th>Status</th>
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

.badge-success {
    background-color: #28a745;
}

.badge-primary {
    background-color: #007bff;
}

.badge-danger {
    background-color: #dc3545;
}
</style>

<script>
$(document).ready(function() {
    let consultasData = [];

    const table = $('#consultasTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 25,
        order: [
            [2, 'desc']
        ],
        dom: 'Bfrtip',
        buttons: [{
                extend: 'excel',
                text: 'Excel',
                className: 'btn btn-success btn-sm'
            },
            {
                extend: 'pdf',
                text: 'PDF',
                className: 'btn btn-danger btn-sm'
            },
            {
                extend: 'print',
                text: 'Imprimir',
                className: 'btn btn-info btn-sm'
            }
        ],
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "Nenhuma consulta encontrada",
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

    // Dados mockados
    consultasData = [{
            id: 1,
            paciente: 'João Silva',
            data: '2025-10-18',
            hora: '09:00',
            valor: 3500,
            status: 'done'
        },
        {
            id: 2,
            paciente: 'Maria Santos',
            data: '2025-10-18',
            hora: '10:30',
            valor: 3000,
            status: 'scheduled'
        },
        {
            id: 3,
            paciente: 'Carlos Alberto',
            data: '2025-10-17',
            hora: '14:00',
            valor: 2500,
            status: 'done'
        },
        {
            id: 4,
            paciente: 'Ana Marques',
            data: '2025-10-16',
            hora: '15:30',
            valor: 4000,
            status: 'canceled'
        },
        {
            id: 5,
            paciente: 'Pedro Gomes',
            data: '2025-10-15',
            hora: '08:30',
            valor: 3000,
            status: 'done'
        }
    ];

    function formatMZN(valor) {
        return valor.toLocaleString('pt-MZ', {
            style: 'currency',
            currency: 'MZN'
        });
    }

    function displayConsultas(data) {
        table.clear();
        let totalValor = 0;

        data.forEach(c => {
            let badge = '';
            switch (c.status) {
                case 'done':
                    badge = '<span class="badge badge-success">Realizada</span>';
                    break;
                case 'scheduled':
                    badge = '<span class="badge badge-primary">Agendada</span>';
                    break;
                case 'canceled':
                    badge = '<span class="badge badge-danger">Cancelada</span>';
                    break;
            }

            if (c.status === 'done') totalValor += c.valor;

            table.row.add([
                c.id,
                c.paciente,
                new Date(c.data).toLocaleDateString('pt-MZ'),
                c.hora,
                formatMZN(c.valor),
                badge
            ]);
        });

        table.draw();

        // Atualizar cards
        $('#total-consultas').text(data.length);
        $('#consultas-realizadas').text(data.filter(c => c.status === 'done').length);
        $('#faturamento').text(formatMZN(totalValor));
        $('#salario-mes').text(formatMZN(totalValor * 0.7)); // 70% do faturamento
    }

    // Filtros
    function applyFilters() {
        const month = $('#month-filter').val();
        const status = $('#status-filter').val();

        let filtered = consultasData;

        if (month !== '') {
            filtered = filtered.filter(c => c.data.startsWith(month));
        }

        if (status !== 'all') {
            filtered = filtered.filter(c => c.status === status);
        }

        displayConsultas(filtered);
    }

    $('#apply-filters').on('click', applyFilters);
    $('#clear-filters').on('click', function() {
        $('#month-filter').val('');
        $('#status-filter').val('all');
        displayConsultas(consultasData);
    });

    displayConsultas(consultasData);

    // Export Excel
    $('#export-excel').on('click', function() {
        table.button('.buttons-excel').trigger();
    });
});
</script>

<?php include_once __DIR__ . './../../src/components/footer.php'; ?>