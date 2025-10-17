<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">

    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Relatório de Estoque de Medicamentos
                </h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-sm d-flex align-items-center shadow-sm" id="export-excel" style="font-size: 0.9rem; padding: 0.35rem 0.7rem;">
                        <i class="icofont icofont-file-excel mr-1" style="font-size: 1rem;"></i>
                        Exportar Excel
                    </button>
                    <a href="link.php?route=25" class="btn btn-primary btn-sm d-flex align-items-center shadow-sm" style="font-size: 0.9rem; padding: 0.35rem 0.7rem;">
                        <i class="icofont icofont-plus mr-1" style="font-size: 1rem;"></i>
                        Nova Entrada
                    </a>
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
                                            <h4 class="mb-0" id="total-medications">-</h4>
                                            <p class="mb-0">Total de Medicamentos</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="icofont icofont-pills" style="font-size: 2rem;"></i>
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
                                            <h4 class="mb-0" id="in-stock">-</h4>
                                            <p class="mb-0">Em Estoque</p>
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
                                            <h4 class="mb-0" id="low-stock">-</h4>
                                            <p class="mb-0">Estoque Baixo</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="icofont icofont-warning" style="font-size: 2rem;"></i>
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
                                            <h4 class="mb-0" id="out-of-stock">-</h4>
                                            <p class="mb-0">Sem Estoque</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="icofont icofont-close-circled" style="font-size: 2rem;"></i>
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
                                                <label for="stock-filter">Filtrar por Estoque</label>
                                                <select class="form-control" id="stock-filter">
                                                    <option value="all">Todos</option>
                                                    <option value="in-stock">Em Estoque (> 0)</option>
                                                    <option value="low-stock">Estoque Baixo (1-10)</option>
                                                    <option value="out-of-stock">Sem Estoque (0)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="search-medication">Buscar Medicamento</label>
                                                <input type="text" class="form-control" id="search-medication" placeholder="Digite o nome do medicamento">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div>
                                                    <button class="btn btn-primary" id="apply-filters">
                                                        <i class="icofont icofont-search mr-1"></i>
                                                        Aplicar Filtros
                                                    </button>
                                                    <button class="btn btn-secondary ml-2" id="clear-filters">
                                                        <i class="icofont icofont-refresh mr-1"></i>
                                                        Limpar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela de Estoque -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h6 class="text-secondary mb-0 text-uppercase">
                                        <i class="icofont icofont-table mr-2"></i>
                                        Estoque de Medicamentos
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="stockTable" class="table table-sm table-striped table-hover align-middle" style="width:100%">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Medicamento</th>
                                                    <th>Descrição</th>
                                                    <th>Estoque Atual</th>
                                                    <th>Status</th>
                                                    <th>Total de Movimentos</th>
                                                    <th>Último Movimento</th>
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

.badge-in-stock {
    background-color: #28a745;
}

.badge-low-stock {
    background-color: #ffc107;
    color: #212529;
}

.badge-out-of-stock {
    background-color: #dc3545;
}

.btn-action {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    margin: 0 0.1rem;
}
</style>

<script>
$(document).ready(function() {
    let stockTable = null;
    let stockData = [];

    // Inicializar DataTable
    stockTable = $('#stockTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 25,
        order: [[3, 'desc']], // Ordenar por estoque atual
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "Nenhum medicamento encontrado",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Sem dados disponíveis",
            search: "Pesquisar:",
            paginate: {
                first: "Primeiro",
                last: "Último",
                next: "Próximo",
                previous: "Anterior"
            }
        },
        dom: 'Bfrtip',
        buttons: [
            {
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
        ]
    });

    // Função para obter badge de status
    function getStockBadge(stock) {
        if (stock === 0) {
            return '<span class="badge badge-out-of-stock">Sem Estoque</span>';
        } else if (stock <= 10) {
            return '<span class="badge badge-low-stock">Estoque Baixo</span>';
        } else {
            return '<span class="badge badge-in-stock">Em Estoque</span>';
        }
    }

    // Carregar relatório de estoque
    function loadStockReport() {
        fetch("routes/index.php?route=stock-movements&action=report")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    stockData = data.data;
                    displayStockData(stockData);
                    updateSummaryCards(stockData);
                } else {
                    console.error('Erro ao carregar relatório:', data);
                }
            }).catch(err => console.error('Erro na requisição:', err));
    }

    // Exibir dados na tabela
    function displayStockData(data) {
        stockTable.clear();
        data.forEach(item => {
            const stock = parseInt(item.current_stock);
            const lastMovement = item.last_movement_date ? 
                new Date(item.last_movement_date).toLocaleDateString('pt-BR') : 
                'Nunca';
            
            stockTable.row.add([
                item.medication_id,
                item.medication_name,
                item.medication_description || '-',
                stock,
                getStockBadge(stock),
                item.total_movements,
                lastMovement,
                `<button class="btn btn-primary btn-action" onclick="addStock(${item.medication_id}, '${item.medication_name}')">
                    <i class="icofont icofont-plus"></i> Entrada
                </button>
                <button class="btn btn-info btn-action" onclick="viewHistory(${item.medication_id}, '${item.medication_name}')">
                    <i class="icofont icofont-history"></i> Histórico
                </button>`
            ]);
        });
        stockTable.draw();
    }

    // Atualizar cards de resumo
    function updateSummaryCards(data) {
        const total = data.length;
        const inStock = data.filter(item => parseInt(item.current_stock) > 0).length;
        const lowStock = data.filter(item => {
            const stock = parseInt(item.current_stock);
            return stock > 0 && stock <= 10;
        }).length;
        const outOfStock = data.filter(item => parseInt(item.current_stock) === 0).length;

        $('#total-medications').text(total);
        $('#in-stock').text(inStock);
        $('#low-stock').text(lowStock);
        $('#out-of-stock').text(outOfStock);
    }

    // Aplicar filtros
    function applyFilters() {
        const stockFilter = $('#stock-filter').val();
        const searchText = $('#search-medication').val().toLowerCase();

        let filteredData = stockData;

        // Filtro por estoque
        if (stockFilter !== 'all') {
            filteredData = filteredData.filter(item => {
                const stock = parseInt(item.current_stock);
                switch (stockFilter) {
                    case 'in-stock':
                        return stock > 0;
                    case 'low-stock':
                        return stock > 0 && stock <= 10;
                    case 'out-of-stock':
                        return stock === 0;
                    default:
                        return true;
                }
            });
        }

        // Filtro por nome
        if (searchText) {
            filteredData = filteredData.filter(item => 
                item.medication_name.toLowerCase().includes(searchText)
            );
        }

        displayStockData(filteredData);
    }

    // Event listeners
    $('#apply-filters').on('click', applyFilters);
    
    $('#clear-filters').on('click', function() {
        $('#stock-filter').val('all');
        $('#search-medication').val('');
        displayStockData(stockData);
    });

    $('#search-medication').on('keypress', function(e) {
        if (e.which === 13) { // Enter
            applyFilters();
        }
    });

    $('#export-excel').on('click', function() {
        stockTable.button('.buttons-excel').trigger();
    });

    // Funções globais
    window.addStock = function(medicationId, medicationName) {
        window.location.href = `link.php?route=25`;
    };

    window.viewHistory = function(medicationId, medicationName) {
        // Implementar modal ou página de histórico
        swal("Histórico", `Histórico de movimentos para: ${medicationName}`, "info");
    };

    // Inicializar
    loadStockReport();
});
</script>

<?php include_once __DIR__ . './../../src/components/footer.php'; ?>
