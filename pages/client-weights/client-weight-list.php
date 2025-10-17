<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">

    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Gestão de Pesos dos Clientes
                </h5>
                <button class="btn btn-success btn-sm d-flex align-items-center shadow-sm" id="btnAddWeight"
                    style="font-size: 0.9rem; padding: 0.35rem 0.7rem;">
                    <i class="icofont icofont-plus mr-1" style="font-size: 1rem;"></i>
                    Novo Registro
                </button>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-secondary mb-0 text-uppercase">Tabela de Pesos dos Clientes</h6>
                                <small class="text-muted">Visualização geral dos registros de peso</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="clientWeightTable" class="table table-sm table-striped table-hover align-middle"
                                    style="width:100%">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Altura (m)</th>
                                            <th>Peso (kg)</th>
                                            <th>IMC</th>
                                            <th>Classificação</th>
                                            <th>Data de Registro</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php include_once __DIR__ . '/client-weight-modal.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ---------- Layout clínico e limpo ---------- */
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

#clientWeightTable {
    border: 1px solid #dee2e6;
}

/* ---------- Ícones e botões ---------- */
#clientWeightTable .btn-sm {
    padding: 4px 6px;
    font-size: 0.85rem;
    margin: 0 3px;
    border-radius: 6px;
    transition: all 0.2s ease-in-out;
}

.btn-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
}

.btn-icon i {
    font-size: 1rem;
}

.btn-info {
    background-color: #17a2b8 !important;
    border: none;
}

.btn-info:hover {
    background-color: #138496 !important;
    transform: scale(1.05);
}

.btn-primary {
    background-color: #6c757d !important;
    border: none;
}

.btn-primary:hover {
    background-color: #5a6268 !important;
    transform: scale(1.05);
}

.btn-danger {
    background-color: #dc3545 !important;
    border: none;
}

.btn-danger:hover {
    background-color: #c82333 !important;
    transform: scale(1.05);
}

/* ---------- Centraliza os títulos das colunas ---------- */
#clientWeightTable thead th {
    text-align: center !important;
    vertical-align: middle;
}

/* ---------- DataTables ---------- */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 10px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 2px 6px !important;
    font-size: 0.85rem;
}

.dataTables_wrapper .dataTables_info {
    font-size: 0.85rem;
    color: #6c757d;
}

/* ---------- Badges para classificação ---------- */
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

<script>
$(document).ready(function() {
    const table = $('#clientWeightTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        order: [[6, 'desc']], // Ordenar por data de criação (mais recente primeiro)
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
        },
        columnDefs: [{
            targets: -1,
            data: null,
            orderable: false,
            className: "text-center",
            defaultContent: `
               <button class="btn btn-sm btn-info btn-icon action" data-action="view" title="Visualizar">
                    <i class="icofont icofont-eye" style="font-size: 1.3rem;"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-icon action" data-action="edit" title="Editar">
                    <i class="icofont icofont-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-icon action" data-action="delete" title="Eliminar">
                    <i class="icofont icofont-trash"></i>
                </button>
            `
        }]
    });

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

    // Carrega registros de peso
    function loadClientWeights() {
        fetch("routes/index.php?route=client-weights")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    table.clear();
                    data.data.forEach(weight => {
                        const formattedDate = new Date(weight.created_at).toLocaleString('pt-BR');
                        table.row.add([
                            weight.id,
                            weight.client_name || 'Cliente não encontrado',
                            parseFloat(weight.height).toFixed(2),
                            parseFloat(weight.weight).toFixed(1),
                            parseFloat(weight.bmi).toFixed(1),
                            getClassificationBadge(weight.classification),
                            formattedDate,
                            null
                        ]);
                    });
                    table.draw();
                } else {
                    console.error('Erro ao carregar dados:', data);
                }
            }).catch(err => console.error('Erro na requisição:', err));
    }

    loadClientWeights();

    // Função genérica de ação
    $('#clientWeightTable tbody').on('click', '.action', function() {
        const action = $(this).data('action');
        const data = table.row($(this).parents('tr')).data();

        if (action === "view") {
            $('#view-client').text(data[1]);
            $('#view-height').text(data[2] + ' m');
            $('#view-weight').text(data[3] + ' kg');
            $('#view-bmi').text(data[4]);
            $('#view-classification').html(data[5]);
            $('#view-date').text(data[6]);
            $('#modalViewWeight').modal('show');

        } else if (action === "edit") {
            const weightId = data[0];
            
            // Buscar dados completos do registro para edição
            fetch(`routes/index.php?route=client-weights&id=${weightId}`)
                .then(res => res.json())
                .then(response => {
                    if (response.status === "success" && response.data) {
                        const weight = response.data;
                        
                        $('#edit-weightid').val(weight.id);
                        $('#edit-height').val(parseFloat(weight.height).toFixed(2));
                        $('#edit-weight').val(parseFloat(weight.weight).toFixed(1));
                        $('#edit-bmi').val(parseFloat(weight.bmi).toFixed(1));
                        $('#edit-classification').val(weight.classification);
                        
                        // Carregar clientes e selecionar o correto
                        loadClientsForEdit(weight.client_name, weight.client_id);
                        $('#modalEditWeight').modal('show');
                    } else {
                        swal("Erro!", "Não foi possível carregar os dados do registro.", "error");
                    }
                })
                .catch(err => {
                    console.error('Erro ao buscar dados do registro:', err);
                    swal("Erro!", "Erro ao carregar dados do registro.", "error");
                });

        } else if (action === "delete") {
            $('#delete-weightid').val(data[0]);
            $('#delete-client').text(data[1]);
            $('#modalDeleteWeight').modal('show');
        }
    });

    // Abrir modal de adicionar
    $('#btnAddWeight').on('click', function() {
        $('#formAddWeight')[0].reset();
        loadClientsForAdd();
        $('#modalAddWeight').modal('show');
    });

    // Função para carregar clientes no select
    function loadClientsForAdd() {
        fetch("routes/index.php?route=patients")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    const select = $('#add-client_id');
                    select.empty().append('<option value="">Selecione um cliente</option>');
                    data.data.forEach(patient => {
                        select.append(`<option value="${patient.id}">${patient.name}</option>`);
                    });
                }
            }).catch(err => console.error('Erro ao carregar clientes:', err));
    }

    function loadClientsForEdit(selectedClientName, selectedClientId) {
        fetch("routes/index.php?route=patients")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    const select = $('#edit-client_id');
                    select.empty().append('<option value="">Selecione um cliente</option>');
                    data.data.forEach(patient => {
                        // Usar ID como critério principal, nome como fallback
                        const isSelected = (selectedClientId && patient.id == selectedClientId) || 
                                         (patient.name === selectedClientName) ? 'selected' : '';
                        select.append(`<option value="${patient.id}" ${isSelected}>${patient.name}</option>`);
                    });
                }
            }).catch(err => console.error('Erro ao carregar clientes:', err));
    }

    // Submissão do Adicionar Peso
    $('#formAddWeight').on('submit', function(e) {
        e.preventDefault();

        const payload = {
            action: "add",
            client_id: Number($('#add-client_id').val()),
            height: parseFloat($('#add-height').val()),
            weight: parseFloat($('#add-weight').val()),
            bmi: $('#add-bmi').val() ? parseFloat($('#add-bmi').val()) : null,
            classification: $('#add-classification').val() || null
        };

        fetch("routes/index.php?route=client-weights", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalAddWeight').modal('hide');
                    loadClientWeights();
                    swal("Sucesso!", "Registro de peso adicionado.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao adicionar registro:", err));
    });

    // Submissão do Editar Peso
    $('#formEditWeight').on('submit', function(e) {
        e.preventDefault();

        const payload = {
            id: Number($('#edit-weightid').val()),
            client_id: Number($('#edit-client_id').val()),
            height: parseFloat($('#edit-height').val()),
            weight: parseFloat($('#edit-weight').val()),
            bmi: $('#edit-bmi').val() ? parseFloat($('#edit-bmi').val()) : null,
            classification: $('#edit-classification').val() || null
        };

        fetch("routes/index.php?route=client-weights", {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalEditWeight').modal('hide');
                    loadClientWeights();
                    swal("Sucesso!", "Registro atualizado com sucesso.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao atualizar registro:", err));
    });

    // Confirmar delete
    $('#confirmDeleteWeight').on('click', function() {
        const weightId = Number($('#delete-weightid').val());

        fetch(`routes/index.php?route=client-weights&id=${weightId}`, {
                method: "DELETE"
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalDeleteWeight').modal('hide');
                    loadClientWeights();
                    swal("Deletado!", "Registro excluído.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao deletar registro:", err));
    });
});
</script>

<?php include_once __DIR__ . './../../src/components/footer.php'; ?>
