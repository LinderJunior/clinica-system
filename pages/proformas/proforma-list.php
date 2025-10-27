<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">

    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Gestão de Facturas
                </h5>
                <button class="btn btn-success btn-sm d-flex align-items-center shadow-sm" id="btnAddProforma"
                    style="font-size: 0.9rem; padding: 0.35rem 0.7rem;">
                    <i class="icofont icofont-plus mr-1" style="font-size: 1rem;"></i>
                    Nova Factura
                </button>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- Filtros -->
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body py-2">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="form-label text-muted small">Filtrar por Status</label>
                                        <select class="form-control form-control-sm" id="statusFilter">
                                            <option value="">Todos os Status</option>
                                            <option value="PENDING">Pendente</option>
                                            <option value="APPROVED">Aprovado</option>
                                            <option value="CANCELLED">Cancelado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label class="form-label text-muted small">Buscar por Cliente</label>
                                        <input type="text" class="form-control form-control-sm" id="clientSearch" 
                                               placeholder="Digite o nome do cliente...">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="form-label text-muted small">&nbsp;</label>
                                        <div>
                                            <button class="btn btn-primary btn-sm" id="btnSearch">
                                                <i class="icofont icofont-search-1 mr-1"></i>Buscar
                                            </button>
                                            <button class="btn btn-secondary btn-sm ml-1" id="btnClearSearch">
                                                <i class="icofont icofont-refresh mr-1"></i>Limpar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label class="form-label text-muted small">&nbsp;</label>
                                        <div>
                                            <button class="btn btn-info btn-sm" id="btnRefresh">
                                                <i class="icofont icofont-refresh mr-1"></i>Atualizar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela de Proformas -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-secondary mb-0 text-uppercase">Tabela de Proformas</h6>
                                <small class="text-muted">Visualização geral de proformas registadas</small>
                            </div>
                            <div>
                                <span class="badge badge-info" id="totalProformas">0 proformas</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="proformaTable" class="table table-sm table-striped table-hover align-middle"
                                    style="width:100%">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nº Proforma</th>
                                            <th>Cliente</th>
                                            <th>Data Emissão</th>
                                            <th>Data Vencimento</th>
                                            <th>Moeda</th>
                                            <th>Subtotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Itens</th>
                                            <th class="text-center">Ações</th>
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

<!-- Modal para Visualizar Proforma -->
<div class="modal fade" id="viewProformaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="icofont icofont-eye mr-2"></i>Detalhes da Proforma
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="proformaDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btnEditFromView">
                    <i class="icofont icofont-edit mr-1"></i>Editar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Confirmar Exclusão -->
<div class="modal fade" id="deleteProformaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="icofont icofont-warning mr-2"></i>Confirmar Exclusão
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir esta proforma?</p>
                <p class="text-muted small">Esta ação não pode ser desfeita.</p>
                <div id="deleteProformaInfo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDelete">
                    <i class="icofont icofont-trash mr-1"></i>Excluir
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let proformaTable;
    let currentProformaId = null;

    // Inicializar DataTable
    function initDataTable() {
        proformaTable = $('#proformaTable').DataTable({
            "processing": true,
            "serverSide": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": [11] },
                { "className": "text-center", "targets": [0, 9, 10, 11] },
                { "className": "text-right", "targets": [6, 7, 8] }
            ],
            "order": [[0, "desc"]]
        });
    }

    // Carregar proformas
    function loadProformas() {
        $.ajax({
            url: 'routes/proformaRoutes.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    populateTable(response.data);
                    $('#totalProformas').text(response.data.length + ' proforma(s)');
                } else {
                    showAlert('error', 'Erro ao carregar proformas: ' + response.message);
                }
            },
            error: function() {
                showAlert('error', 'Erro de conexão ao carregar proformas.');
            }
        });
    }

    // Popular tabela
    function populateTable(data) {
        proformaTable.clear();
        
        data.forEach(function(proforma) {
            const statusBadge = getStatusBadge(proforma.status);
            const formattedDate = formatDate(proforma.issue_date);
            const formattedDueDate = formatDate(proforma.due_date);
            
            proformaTable.row.add([
                proforma.id,
                proforma.invoice_number,
                proforma.client_name,
                formattedDate,
                formattedDueDate,
                proforma.currency,
                formatCurrency(proforma.subtotal, proforma.currency),
                formatCurrency(proforma.tax, proforma.currency),
                formatCurrency(proforma.total, proforma.currency),
                statusBadge,
                '<span class="badge badge-secondary">' + (proforma.total_items || 0) + '</span>',
                getActionButtons(proforma)
            ]);
        });
        
        proformaTable.draw();
    }

    // Obter badge de status
    function getStatusBadge(status) {
        const badges = {
            'PENDING': '<span class="badge badge-warning">Pendente</span>',
            'APPROVED': '<span class="badge badge-success">Aprovado</span>',
            'CANCELLED': '<span class="badge badge-danger">Cancelado</span>'
        };
        return badges[status] || '<span class="badge badge-secondary">' + status + '</span>';
    }

    // Obter botões de ação
    function getActionButtons(proforma) {
        return `
            <div class="btn-group" role="group">
                <button class="btn btn-info btn-sm" onclick="viewProforma(${proforma.id})" title="Visualizar">
                    <i class="icofont icofont-eye"></i>
                </button>
                <button class="btn btn-success btn-sm" onclick="generatePDF(${proforma.id})" title="Gerar PDF">
                    <i class="icofont icofont-file-pdf"></i>
                </button>
                <button class="btn btn-secondary btn-sm" onclick="downloadPDF(${proforma.id})" title="Download PDF">
                    <i class="icofont icofont-download"></i>
                </button>
                <button class="btn btn-primary btn-sm" onclick="editProforma(${proforma.id})" title="Editar">
                    <i class="icofont icofont-edit"></i>
                </button>
                <button class="btn btn-warning btn-sm" onclick="changeStatus(${proforma.id}, '${proforma.status}')" title="Alterar Status">
                    <i class="icofont icofont-refresh"></i>
                </button>
                <button class="btn btn-danger btn-sm" onclick="deleteProforma(${proforma.id}, '${proforma.invoice_number}')" title="Excluir">
                    <i class="icofont icofont-trash"></i>
                </button>
            </div>
        `;
    }

    // Formatar data
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('pt-BR');
    }

    // Formatar moeda
    function formatCurrency(amount, currency = 'MZN') {
        const value = parseFloat(amount) || 0;
        return value.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) + ' ' + currency;
    }

    // Event Listeners
    $('#btnAddProforma').click(function() {
        window.location.href = 'proforma-register.php';
    });

    $('#btnRefresh').click(function() {
        loadProformas();
    });

    $('#btnSearch').click(function() {
        const status = $('#statusFilter').val();
        const client = $('#clientSearch').val().trim();
        
        if (status) {
            searchByStatus(status);
        } else if (client) {
            searchByClient(client);
        } else {
            loadProformas();
        }
    });

    $('#btnClearSearch').click(function() {
        $('#statusFilter').val('');
        $('#clientSearch').val('');
        loadProformas();
    });

    $('#btnConfirmDelete').click(function() {
        if (currentProformaId) {
            confirmDeleteProforma(currentProformaId);
        }
    });

    // Buscar por status
    function searchByStatus(status) {
        $.ajax({
            url: 'routes/proformaRoutes.php?status=' + encodeURIComponent(status),
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    populateTable(response.data);
                    $('#totalProformas').text(response.data.length + ' proforma(s)');
                } else {
                    showAlert('error', 'Erro ao buscar proformas: ' + response.message);
                }
            },
            error: function() {
                showAlert('error', 'Erro de conexão ao buscar proformas.');
            }
        });
    }

    // Buscar por cliente
    function searchByClient(client) {
        $.ajax({
            url: 'routes/proformaRoutes.php?search=' + encodeURIComponent(client),
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    populateTable(response.data);
                    $('#totalProformas').text(response.data.length + ' proforma(s)');
                } else {
                    showAlert('error', 'Erro ao buscar proformas: ' + response.message);
                }
            },
            error: function() {
                showAlert('error', 'Erro de conexão ao buscar proformas.');
            }
        });
    }

    // Funções globais
    window.viewProforma = function(id) {
        $.ajax({
            url: 'routes/proformaRoutes.php?id=' + id,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    displayProformaDetails(response.data);
                    $('#viewProformaModal').modal('show');
                } else {
                    showAlert('error', 'Erro ao carregar detalhes: ' + response.message);
                }
            },
            error: function() {
                showAlert('error', 'Erro de conexão ao carregar detalhes.');
            }
        });
    };

    window.editProforma = function(id) {
        window.location.href = 'proforma-register.php?id=' + id;
    };

    window.changeStatus = function(id, currentStatus) {
        const statuses = ['PENDING', 'APPROVED', 'CANCELLED'];
        const statusNames = {'PENDING': 'Pendente', 'APPROVED': 'Aprovado', 'CANCELLED': 'Cancelado'};
        
        let options = '';
        statuses.forEach(status => {
            const selected = status === currentStatus ? 'selected' : '';
            options += `<option value="${status}" ${selected}>${statusNames[status]}</option>`;
        });
        
        Swal.fire({
            title: 'Alterar Status',
            html: `<select id="newStatus" class="form-control">${options}</select>`,
            showCancelButton: true,
            confirmButtonText: 'Alterar',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                return document.getElementById('newStatus').value;
            }
        }).then((result) => {
            if (result.isConfirmed && result.value !== currentStatus) {
                updateProformaStatus(id, result.value);
            }
        });
    };

    window.deleteProforma = function(id, invoiceNumber) {
        currentProformaId = id;
        $('#deleteProformaInfo').html(`
            <strong>Proforma:</strong> ${invoiceNumber}<br>
            <strong>ID:</strong> ${id}
        `);
        $('#deleteProformaModal').modal('show');
    };

    // Gerar PDF (visualizar)
    window.generatePDF = function(id) {
        const url = `routes/proformaPDF.php?id=${id}&action=preview`;
        window.open(url, '_blank');
    };

    // Download PDF
    window.downloadPDF = function(id) {
        const url = `routes/proformaPDF.php?id=${id}&action=download`;
        window.location.href = url;
    };

    // Atualizar status
    function updateProformaStatus(id, status) {
        $.ajax({
            url: 'routes/proformaRoutes.php',
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'update_status',
                id: id,
                status: status
            }),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', response.message);
                    loadProformas();
                } else {
                    showAlert('error', 'Erro ao atualizar status: ' + response.message);
                }
            },
            error: function() {
                showAlert('error', 'Erro de conexão ao atualizar status.');
            }
        });
    }

    // Confirmar exclusão
    function confirmDeleteProforma(id) {
        $.ajax({
            url: 'routes/proformaRoutes.php',
            method: 'DELETE',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'delete',
                id: id
            }),
            dataType: 'json',
            success: function(response) {
                $('#deleteProformaModal').modal('hide');
                if (response.status === 'success') {
                    showAlert('success', response.message);
                    loadProformas();
                } else {
                    showAlert('error', 'Erro ao excluir proforma: ' + response.message);
                }
            },
            error: function() {
                $('#deleteProformaModal').modal('hide');
                showAlert('error', 'Erro de conexão ao excluir proforma.');
            }
        });
    }

    // Exibir detalhes da proforma
    function displayProformaDetails(proforma) {
        let itemsHtml = '';
        if (proforma.items && proforma.items.length > 0) {
            itemsHtml = `
                <h6 class="mt-3">Itens da Proforma:</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Descrição</th>
                                <th class="text-center">Qtd</th>
                                <th class="text-right">Preço Unit.</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            proforma.items.forEach(item => {
                itemsHtml += `
                    <tr>
                        <td>${item.description}</td>
                        <td class="text-center">${item.quantity}</td>
                        <td class="text-right">${formatCurrency(item.unit_price, proforma.currency)}</td>
                        <td class="text-right">${formatCurrency(item.total_price, proforma.currency)}</td>
                    </tr>
                `;
            });
            
            itemsHtml += '</tbody></table></div>';
        } else {
            itemsHtml = '<p class="text-muted mt-3">Nenhum item adicionado a esta proforma.</p>';
        }

        const detailsHtml = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Informações Gerais</h6>
                    <table class="table table-sm table-borderless">
                        <tr><td><strong>Nº Proforma:</strong></td><td>${proforma.invoice_number}</td></tr>
                        <tr><td><strong>Cliente:</strong></td><td>${proforma.client_name}</td></tr>
                        <tr><td><strong>Data Emissão:</strong></td><td>${formatDate(proforma.issue_date)}</td></tr>
                        <tr><td><strong>Data Vencimento:</strong></td><td>${formatDate(proforma.due_date)}</td></tr>
                        <tr><td><strong>Status:</strong></td><td>${getStatusBadge(proforma.status)}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Valores</h6>
                    <table class="table table-sm table-borderless">
                        <tr><td><strong>Moeda:</strong></td><td>${proforma.currency}</td></tr>
                        <tr><td><strong>Subtotal:</strong></td><td>${formatCurrency(proforma.subtotal, proforma.currency)}</td></tr>
                        <tr><td><strong>IVA (16%):</strong></td><td>${formatCurrency(proforma.tax, proforma.currency)}</td></tr>
                        <tr><td><strong>Total:</strong></td><td class="h6 text-primary">${formatCurrency(proforma.total, proforma.currency)}</td></tr>
                    </table>
                </div>
            </div>
            ${proforma.notes ? `<div class="mt-3"><h6>Observações:</h6><p class="text-muted">${proforma.notes}</p></div>` : ''}
            ${itemsHtml}
        `;

        $('#proformaDetails').html(detailsHtml);
        $('#btnEditFromView').off('click').on('click', function() {
            $('#viewProformaModal').modal('hide');
            editProforma(proforma.id);
        });
    }

    // Função para exibir alertas
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        `;
        
        // Remove alertas existentes
        $('.alert').remove();
        
        // Adiciona novo alerta
        $('.pcoded-content').prepend(alertHtml);
        
        // Auto-remove após 5 segundos
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 5000);
    }

    // Inicializar
    initDataTable();
    loadProformas();
});
</script>

<?php include_once __DIR__ . './../../src/components/footer.php'; ?>
