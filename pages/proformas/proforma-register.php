<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">
    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;" id="pageTitle">
                    Nova Factura
                </h5>
                <a href="proforma-list.php" class="btn btn-secondary btn-sm d-flex align-items-center shadow-sm">
                    <i class="icofont icofont-arrow-left mr-1"></i>
                    Voltar à Lista
                </a>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <form id="proformaForm">
                        <input type="hidden" id="proformaId" name="id">
                        
                        <!-- Informações Gerais -->
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-header bg-light">
                                <h6 class="text-secondary mb-0 text-uppercase">
                                    <i class="icofont icofont-info-circle mr-2"></i>Informações Gerais
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Número da Factura <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="invoiceNumber" name="invoice_number" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nome do Cliente <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="clientName" name="client_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Moeda</label>
                                            <select class="form-control" id="currency" name="currency">
                                                <option value="MZN">MZN - Metical</option>
                                                <option value="USD">USD - Dólar</option>
                                                <option value="EUR">EUR - Euro</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Data de Emissão <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="issueDate" name="issue_date" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Data de Vencimento</label>
                                            <input type="date" class="form-control" id="dueDate" name="due_date">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="PENDING">Pendente</option>
                                                <option value="APPROVED">Aprovado</option>
                                                <option value="CANCELLED">Cancelado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Observações</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Observações adicionais..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Itens da Proforma -->
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="text-secondary mb-0 text-uppercase">
                                    <i class="icofont icofont-list mr-2"></i>Itens da Proforma
                                </h6>
                                <button type="button" class="btn btn-success btn-sm" id="btnAddItem">
                                    <i class="icofont icofont-plus mr-1"></i>Adicionar Item
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered" id="itemsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="40%">Descrição</th>
                                                <th width="15%" class="text-center">Quantidade</th>
                                                <th width="20%" class="text-right">Preço Unitário</th>
                                                <th width="20%" class="text-right">Total</th>
                                                <th width="5%" class="text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsTableBody">
                                            <tr id="noItemsRow">
                                                <td colspan="5" class="text-center text-muted">
                                                    Nenhum item adicionado. Clique em "Adicionar Item" para começar.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Totais -->
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-header bg-light">
                                <h6 class="text-secondary mb-0 text-uppercase">
                                    <i class="icofont icofont-calculator mr-2"></i>Totais
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td><strong>Subtotal:</strong></td>
                                                <td class="text-right" id="subtotalDisplay">0.00 MZN</td>
                                            </tr>
                                            <tr>
                                                <td><strong>IVA (16%):</strong></td>
                                                <td class="text-right" id="taxDisplay">0.00 MZN</td>
                                            </tr>
                                            <tr class="border-top">
                                                <td><strong>Total:</strong></td>
                                                <td class="text-right h6 text-primary" id="totalDisplay">0.00 MZN</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botões de Ação -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body text-center">
                                <button type="button" class="btn btn-secondary mr-2" onclick="window.location.href='link.php?route=28'">
                                    <i class="icofont icofont-close mr-1"></i>Cancelar
                                </button>
                                <button type="button" class="btn btn-info mr-2" id="btnPreviewPDF">
                                    <i class="icofont icofont-file-pdf mr-1"></i>Preview PDF
                                </button>
                                <button type="submit" class="btn btn-success" id="btnSave">
                                    <i class="icofont icofont-save mr-1"></i>Salvar Proforma
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Adicionar/Editar Item -->
<div class="modal fade" id="itemModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="itemModalTitle">
                    <i class="icofont icofont-plus mr-2"></i>Adicionar Item
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="itemForm">
                    <input type="hidden" id="itemIndex" name="item_index">
                    
                    <div class="form-group">
                        <label class="form-label">Descrição <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="itemDescription" name="description" rows="3" required placeholder="Descrição detalhada do item..."></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Quantidade <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="itemQuantity" name="quantity" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Preço Unitário <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="itemUnitPrice" name="unit_price" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Total</label>
                        <input type="text" class="form-control" id="itemTotal" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnSaveItem">
                    <i class="icofont icofont-save mr-1"></i>Salvar Item
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Preview PDF -->
<div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="icofont icofont-file-pdf mr-2"></i>Preview da Proforma
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <iframe id="pdfFrame" width="100%" height="600px" style="border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btnDownloadPreview">
                    <i class="icofont icofont-download mr-1"></i>Download PDF
                </button>
                <button type="button" class="btn btn-success" id="btnSaveFromPreview">
                    <i class="icofont icofont-save mr-1"></i>Salvar Proforma
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let items = [];
    let editingItemIndex = -1;
    let isEditMode = false;
    let currentProformaId = null;

    // Verificar se é modo de edição
    const urlParams = new URLSearchParams(window.location.search);
    const proformaId = urlParams.get('id');
    
    if (proformaId) {
        isEditMode = true;
        currentProformaId = proformaId;
        $('#pageTitle').text('Editar Proforma');
        $('#btnSave').html('<i class="icofont icofont-save mr-1"></i>Atualizar Proforma');
        loadProformaForEdit(proformaId);
    } else {
        // Modo de criação - gerar próximo número
        generateNextInvoiceNumber();
        setDefaultDates();
    }

    // Gerar próximo número de invoice
    function generateNextInvoiceNumber() {
        $.ajax({
            url: 'routes/proformaRoutes.php?action=next_invoice_number',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#invoiceNumber').val(response.data.next_invoice_number);
                }
            },
            error: function() {
                console.error('Erro ao gerar número da invoice');
            }
        });
    }

    // Definir datas padrão
    function setDefaultDates() {
        const today = new Date();
        const dueDate = new Date(today);
        dueDate.setDate(today.getDate() + 30); // 30 dias a partir de hoje
        
        $('#issueDate').val(today.toISOString().split('T')[0]);
        $('#dueDate').val(dueDate.toISOString().split('T')[0]);
    }

    // Carregar proforma para edição
    function loadProformaForEdit(id) {
        $.ajax({
            url: 'routes/proformaRoutes.php?id=' + id,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    const proforma = response.data;
                    
                    // Preencher campos
                    $('#proformaId').val(proforma.id);
                    $('#invoiceNumber').val(proforma.invoice_number);
                    $('#clientName').val(proforma.client_name);
                    $('#issueDate').val(proforma.issue_date);
                    $('#dueDate').val(proforma.due_date);
                    $('#currency').val(proforma.currency);
                    $('#status').val(proforma.status);
                    $('#notes').val(proforma.notes);
                    
                    // Carregar itens
                    if (proforma.items && proforma.items.length > 0) {
                        items = proforma.items.map(item => ({
                            description: item.description,
                            quantity: parseInt(item.quantity),
                            unit_price: parseFloat(item.unit_price)
                        }));
                        renderItemsTable();
                        calculateTotals();
                    }
                } else {
                    showAlert('error', 'Erro ao carregar proforma: ' + response.message);
                }
            },
            error: function() {
                showAlert('error', 'Erro de conexão ao carregar proforma.');
            }
        });
    }

    // Event Listeners
    $('#btnAddItem').click(function() {
        openItemModal();
    });

    $('#btnSaveItem').click(function() {
        saveItem();
    });

    $('#itemQuantity, #itemUnitPrice').on('input', function() {
        calculateItemTotal();
    });

    $('#proformaForm').submit(function(e) {
        e.preventDefault();
        saveProforma();
    });

    $('#btnPreviewPDF').click(function() {
        previewPDF();
    });

    $('#btnDownloadPreview').click(function() {
        if (currentProformaId) {
            downloadPDF(currentProformaId);
        }
    });

    $('#btnSaveFromPreview').click(function() {
        $('#pdfPreviewModal').modal('hide');
        saveProforma();
    });

    // Abrir modal de item
    function openItemModal(index = -1) {
        editingItemIndex = index;
        
        if (index >= 0) {
            // Modo edição
            const item = items[index];
            $('#itemModalTitle').html('<i class="icofont icofont-edit mr-2"></i>Editar Item');
            $('#itemDescription').val(item.description);
            $('#itemQuantity').val(item.quantity);
            $('#itemUnitPrice').val(item.unit_price);
            calculateItemTotal();
        } else {
            // Modo criação
            $('#itemModalTitle').html('<i class="icofont icofont-plus mr-2"></i>Adicionar Item');
            $('#itemForm')[0].reset();
            $('#itemTotal').val('0.00');
        }
        
        $('#itemModal').modal('show');
    }

    // Calcular total do item
    function calculateItemTotal() {
        const quantity = parseFloat($('#itemQuantity').val()) || 0;
        const unitPrice = parseFloat($('#itemUnitPrice').val()) || 0;
        const total = quantity * unitPrice;
        
        const currency = $('#currency').val();
        $('#itemTotal').val(formatCurrency(total, currency));
    }

    // Salvar item
    function saveItem() {
        const description = $('#itemDescription').val().trim();
        const quantity = parseInt($('#itemQuantity').val());
        const unitPrice = parseFloat($('#itemUnitPrice').val());
        
        if (!description || !quantity || !unitPrice) {
            showAlert('error', 'Por favor, preencha todos os campos obrigatórios.');
            return;
        }
        
        const item = {
            description: description,
            quantity: quantity,
            unit_price: unitPrice
        };
        
        if (editingItemIndex >= 0) {
            // Atualizar item existente
            items[editingItemIndex] = item;
        } else {
            // Adicionar novo item
            items.push(item);
        }
        
        renderItemsTable();
        calculateTotals();
        $('#itemModal').modal('hide');
    }

    // Renderizar tabela de itens
    function renderItemsTable() {
        const tbody = $('#itemsTableBody');
        tbody.empty();
        
        if (items.length === 0) {
            tbody.append(`
                <tr id="noItemsRow">
                    <td colspan="5" class="text-center text-muted">
                        Nenhum item adicionado. Clique em "Adicionar Item" para começar.
                    </td>
                </tr>
            `);
            return;
        }
        
        const currency = $('#currency').val();
        
        items.forEach((item, index) => {
            const total = item.quantity * item.unit_price;
            const row = `
                <tr>
                    <td>${item.description}</td>
                    <td class="text-center">${item.quantity}</td>
                    <td class="text-right">${formatCurrency(item.unit_price, currency)}</td>
                    <td class="text-right">${formatCurrency(total, currency)}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary btn-sm" onclick="editItem(${index})" title="Editar">
                                <i class="icofont icofont-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${index})" title="Remover">
                                <i class="icofont icofont-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    // Calcular totais
    function calculateTotals() {
        let subtotal = 0;
        
        items.forEach(item => {
            subtotal += item.quantity * item.unit_price;
        });
        
        const tax = subtotal * 0.16; // 16% IVA
        const total = subtotal + tax;
        const currency = $('#currency').val();
        
        $('#subtotalDisplay').text(formatCurrency(subtotal, currency));
        $('#taxDisplay').text(formatCurrency(tax, currency));
        $('#totalDisplay').text(formatCurrency(total, currency));
    }

    // Formatar moeda
    function formatCurrency(amount, currency = 'MZN') {
        const value = parseFloat(amount) || 0;
        return value.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) + ' ' + currency;
    }

    // Funções globais
    window.editItem = function(index) {
        openItemModal(index);
    };

    window.removeItem = function(index) {
        Swal.fire({
            title: 'Confirmar Remoção',
            text: 'Tem certeza que deseja remover este item?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, remover',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                items.splice(index, 1);
                renderItemsTable();
                calculateTotals();
            }
        });
    };

    // Salvar proforma
    function saveProforma(forPreview = false) {
        const formData = {
            client_name: $('#clientName').val().trim(),
            issue_date: $('#issueDate').val(),
            due_date: $('#dueDate').val(),
            currency: $('#currency').val(),
            status: $('#status').val(),
            notes: $('#notes').val().trim(),
            items: items
        };

        // Validações
        if (!validateForm()) {
            return;
        }

        // Preparar requisição
        let url = 'routes/proformaRoutes.php';
        let method = 'POST';
        
        if (isEditMode) {
            method = 'PUT';
            formData.action = 'update';
            formData.id = currentProformaId;
            formData.invoice_number = $('#invoiceNumber').val();
        } else {
            formData.action = 'add';
        }

        // Enviar requisição
        $.ajax({
            url: url,
            method: method,
            contentType: 'application/json',
            data: JSON.stringify(formData),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', response.message);
                    
                    if (forPreview) {
                        // Se é para preview, buscar o ID da proforma e mostrar PDF
                        if (!isEditMode) {
                            // Para nova proforma, extrair ID da resposta ou buscar pela invoice number
                            loadLastProformaForPreview();
                        } else {
                            showPDFPreview(currentProformaId);
                        }
                    } else {
                        // Comportamento normal - redirecionar
                        setTimeout(() => {
                            window.location.href = 'link.php?route=28';
                        }, 2000);
                    }
                } else {
                    showAlert('error', 'Erro ao salvar proforma: ' + response.message);
                }
            },
            error: function() {
                showAlert('error', 'Erro de conexão ao salvar proforma.');
            }
        });
    }

    // Preview PDF
    function previewPDF() {
        if (!validateForm()) {
            return;
        }

        if (isEditMode && currentProformaId) {
            // Se está editando, usar ID existente
            showPDFPreview(currentProformaId);
        } else {
            // Se é nova proforma, precisa salvar temporariamente
            showAlert('info', 'Para visualizar o PDF, a proforma precisa ser salva primeiro.');
            saveProforma(true); // true indica que é para preview
        }
    }

    // Mostrar preview do PDF
    function showPDFPreview(proformaId) {
        const url = `routes/proformaPDF.php?id=${proformaId}&action=preview`;
        $('#pdfFrame').attr('src', url);
        $('#pdfPreviewModal').modal('show');
        
        // Atualizar botão de download no modal
        $('#btnDownloadPreview').off('click').on('click', function() {
            downloadPDF(proformaId);
        });
    }

    // Download PDF
    function downloadPDF(proformaId) {
        const url = `routes/proformaPDF.php?id=${proformaId}&action=download`;
        window.location.href = url;
    }

    // Carregar última proforma para preview (após salvar nova)
    function loadLastProformaForPreview() {
        const invoiceNumber = $('#invoiceNumber').val();
        
        $.ajax({
            url: 'routes/proformaRoutes.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'search',
                client_name: $('#clientName').val()
            }),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.data.length > 0) {
                    // Encontrar a proforma pelo número
                    const proforma = response.data.find(p => p.invoice_number === invoiceNumber);
                    if (proforma) {
                        currentProformaId = proforma.id;
                        isEditMode = true;
                        showPDFPreview(proforma.id);
                    }
                }
            },
            error: function() {
                showAlert('error', 'Erro ao carregar proforma para preview.');
            }
        });
    }

    // Validar formulário
    function validateForm() {
        const clientName = $('#clientName').val().trim();
        const issueDate = $('#issueDate').val();

        if (!clientName) {
            showAlert('error', 'Por favor, informe o nome do cliente.');
            return false;
        }

        if (!issueDate) {
            showAlert('error', 'Por favor, informe a data de emissão.');
            return false;
        }

        if (items.length === 0) {
            showAlert('error', 'Por favor, adicione pelo menos um item à proforma.');
            return false;
        }

        return true;
    }

    // Atualizar totais quando a moeda mudar
    $('#currency').change(function() {
        renderItemsTable();
        calculateTotals();
    });

    // Função para exibir alertas
    function showAlert(type, message) {
        let alertClass = 'alert-secondary';
        if (type === 'success') alertClass = 'alert-success';
        else if (type === 'error') alertClass = 'alert-danger';
        else if (type === 'info') alertClass = 'alert-info';
        else if (type === 'warning') alertClass = 'alert-warning';
        
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
});
</script>

<?php include_once __DIR__ . './../../src/components/footer.php'; ?>
