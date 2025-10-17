<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">

    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Entrada de Medicamentos no Estoque
                </h5>
                <a href="link.php?route=16" class="btn btn-secondary btn-sm d-flex align-items-center shadow-sm" style="font-size: 0.9rem; padding: 0.35rem 0.7rem;">
                    <i class="icofont icofont-arrow-left mr-1" style="font-size: 1rem;"></i>
                    Voltar à Lista
                </a>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    
                    <!-- Formulário de Entrada -->
                    <div class="row mb-4">
                        <div class="col-lg-8 mx-auto">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="icofont icofont-plus mr-2"></i>
                                        Registrar Entrada de Medicamento
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form id="stockEntryForm">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="medication_id">Medicamento <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="medication_id" name="medication_id" required>
                                                        <option value="">Selecione um medicamento</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="quantity">Quantidade <span class="text-danger">*</span></label>
                                                    <input type="number" min="1" class="form-control" id="quantity" name="quantity" required>
                                                    <small class="form-text text-muted">Quantidade a ser adicionada ao estoque</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="current_stock">Estoque Atual</label>
                                                    <input type="text" class="form-control" id="current_stock" readonly>
                                                    <small class="form-text text-muted">Estoque atual do medicamento selecionado</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="observation">Observação</label>
                                                    <textarea class="form-control" id="observation" name="observation" rows="3" placeholder="Observações sobre a entrada (opcional)"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4">
                                            <div class="d-flex justify-content-between">
                                                <a href="link.php?route=16" class="btn btn-secondary">
                                                    <i class="icofont icofont-arrow-left mr-1"></i>
                                                    Cancelar
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="icofont icofont-check mr-1"></i>
                                                    Registrar Entrada
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Histórico de Movimentos -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h6 class="text-secondary mb-0 text-uppercase">
                                        <i class="icofont icofont-history mr-2"></i>
                                        Últimas Entradas
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="movementsTable" class="table table-sm table-striped table-hover align-middle" style="width:100%">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>Data/Hora</th>
                                                    <th>Medicamento</th>
                                                    <th>Quantidade</th>
                                                    <th>Tipo</th>
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

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este movimento de estoque?</p>
                <p><strong>Medicamento:</strong> <span id="delete-medication"></span></p>
                <p><strong>Quantidade:</strong> <span id="delete-quantity"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Excluir</button>
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

.badge-entry {
    background-color: #28a745;
}

.badge-exit {
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
    let movementsTable = null;
    let deleteMovementId = null;

    // Inicializar DataTable
    movementsTable = $('#movementsTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        order: [[0, 'desc']], // Ordenar por data (mais recente primeiro)
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "Nenhum movimento encontrado",
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

    // Carregar medicamentos
    function loadMedications() {
        fetch("routes/index.php?route=medications")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    const select = $('#medication_id');
                    select.empty().append('<option value="">Selecione um medicamento</option>');
                    data.data.forEach(medication => {
                        select.append(`<option value="${medication.id}">${medication.name} - ${medication.description}</option>`);
                    });
                }
            }).catch(err => console.error('Erro ao carregar medicamentos:', err));
    }

    // Carregar estoque atual quando medicamento for selecionado
    $('#medication_id').on('change', function() {
        const medicationId = $(this).val();
        if (medicationId) {
            fetch(`routes/index.php?route=stock-movements&action=stock&medication_id=${medicationId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        $('#current_stock').val(data.data.current_stock + ' unidades');
                    } else {
                        $('#current_stock').val('0 unidades');
                    }
                }).catch(err => {
                    console.error('Erro ao carregar estoque:', err);
                    $('#current_stock').val('Erro ao carregar');
                });
        } else {
            $('#current_stock').val('');
        }
    });

    // Carregar movimentos
    function loadMovements() {
        fetch("routes/index.php?route=stock-movements&action=list")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    movementsTable.clear();
                    data.data.forEach(movement => {
                        const formattedDate = new Date(movement.movement_date).toLocaleString('pt-BR');
                        const quantity = parseInt(movement.quantity);
                        const type = quantity > 0 ? 'Entrada' : 'Saída';
                        const typeClass = quantity > 0 ? 'badge-entry' : 'badge-exit';
                        const quantityDisplay = Math.abs(quantity);
                        
                        movementsTable.row.add([
                            formattedDate,
                            movement.medication_name || 'Medicamento não encontrado',
                            quantityDisplay,
                            `<span class="badge ${typeClass}">${type}</span>`,
                            `<button class="btn btn-danger btn-action" onclick="deleteMovement(${movement.id}, '${movement.medication_name}', ${quantityDisplay})">
                                <i class="icofont icofont-trash"></i>
                            </button>`
                        ]);
                    });
                    movementsTable.draw();
                } else {
                    console.error('Erro ao carregar movimentos:', data);
                }
            }).catch(err => console.error('Erro na requisição:', err));
    }

    // Submissão do formulário
    $('#stockEntryForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        
        // Adicionar action para criar movimento
        formData.append('action', 'create');

        fetch("routes/index.php?route=stock-movements&action=create", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                swal("Sucesso!", "Entrada registrada com sucesso!", "success")
                .then(() => {
                    // Limpar formulário
                    $('#stockEntryForm')[0].reset();
                    $('#current_stock').val('');
                    
                    // Recarregar movimentos
                    loadMovements();
                });
            } else {
                swal("Erro!", data.message || "Erro ao registrar entrada.", "error");
            }
        })
        .catch(err => {
            console.error('Erro:', err);
            swal("Erro!", "Erro na comunicação com o servidor.", "error");
        });
    });

    // Função para deletar movimento (global)
    window.deleteMovement = function(id, medicationName, quantity) {
        deleteMovementId = id;
        $('#delete-medication').text(medicationName);
        $('#delete-quantity').text(quantity + ' unidades');
        $('#deleteModal').modal('show');
    };

    // Confirmar exclusão
    $('#confirmDelete').on('click', function() {
        if (deleteMovementId) {
            const formData = new FormData();
            formData.append('id', deleteMovementId);

            fetch("routes/index.php?route=stock-movements&action=delete", {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    swal("Sucesso!", "Movimento excluído com sucesso!", "success")
                    .then(() => {
                        $('#deleteModal').modal('hide');
                        loadMovements();
                    });
                } else {
                    swal("Erro!", data.message || "Erro ao excluir movimento.", "error");
                }
            })
            .catch(err => {
                console.error('Erro:', err);
                swal("Erro!", "Erro na comunicação com o servidor.", "error");
            });
        }
    });

    // Inicializar
    loadMedications();
    loadMovements();
});
</script>

<?php include_once __DIR__ . './../../src/components/footer.php'; ?>
