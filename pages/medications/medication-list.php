<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">

    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Gestão de Medicamentos
                </h5>
                <!-- <button class="btn btn-success btn-sm d-flex align-items-center shadow-sm" id="btnAddMedication"
                    style="font-size: 0.9rem; padding: 0.35rem 0.7rem;">
                    <i class="icofont icofont-plus mr-1" style="font-size: 1rem;"></i>
                    Novo Registo
                </button> -->
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
                                <h6 class="text-secondary mb-0 text-uppercase">Tabela de Medicamentos</h6>
                                <small class="text-muted">Visualização geral de medicamentos registados</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="medicationTable"
                                    class="table table-sm table-striped table-hover align-middle" style="width:100%">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Tipo</th>
                                            <th>Data de Produção</th>
                                            <th>Data de Validade</th>
                                            <th>Quantidade</th>
                                            <th>Número de Lote</th>
                                            <th>Preço de Compra</th>
                                            <th>Preço de Venda</th>
                                            <th>Data de Registo</th>
                                            <th>Descrição</th>
                                            <th>Registado por</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php include_once __DIR__ . '/medication-modal.php'; ?>
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

#medicationTable {
    border: 1px solid #dee2e6;
}

#medicationTable .btn-sm {
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

#medicationTable thead th {
    text-align: center !important;
    vertical-align: middle;
}

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
</style>

<script>
$(document).ready(function() {
    const table = $('#medicationTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        language: {
            lengthMenu: "Mostrar _MENU_ medicamentos",
            zeroRecords: "Nenhum medicamento encontrado",
            info: "Mostrando _START_ a _END_ de _TOTAL_ medicamentos",
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

    function loadMedications() {
        fetch("routes/medicationRoutes.php")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    table.clear();
                    data.data.forEach(medication => table.row.add([
                        medication.id,
                        medication.name,
                        medication.type,
                        medication.dateProduction,
                        medication.dateExpiry,
                        medication.qty,
                        medication.loteNumber,
                        medication.purchasePrice,
                        medication.salePrice,
                        medication.registationDate,
                        medication.description,
                        medication.user_id,
                        null
                    ]));
                    table.draw();
                }
            }).catch(err => console.error(err));
    }

    loadMedications();

    // Função genérica de ação
    $('#medicationTable tbody').on('click', '.action', function() {
        const action = $(this).data('action');
        const data = table.row($(this).parents('tr')).data();

        if (action === "view") {
            // IDs baseados na estrutura do modalViewMedication
            $('#view-name').text(data[1]); // Nome do medicamento
            $('#view-type').text(data[2]); // Tipo (Antibiótico, Analgésico, etc.)
            $('#view-dateProduction').text(data[3]); // Data de Produção
            $('#view-dateExpiry').text(data[4]); // Data de Expiração
            $('#view-qty').text(data[5]); // Quantidade
            $('#view-loteNumber').text(data[6]); // Número do Lote
            $('#view-purchasePrice').text(data[7] + " MZN"); // Preço de Compra
            $('#view-salePrice').text(data[8] + " MZN"); // Preço de Venda
            $('#view-registationDate').text(data[9]); // Data de Registo
            $('#view-description').text(data[10]); // Descrição do medicamento
            $('#view-user').text("Usuário ID: " + data[11]); // Usuário responsável

            // Exibe o modal
            $('#modalViewMedication').modal('show');
        } else if (action === "edit") {
            $('#edit-medicationid').val(data[0]); // id
            $('#edit-name').val(data[1]); // name
            $('#edit-type').val(data[2]); // type
            $('#edit-dateProduction').val(data[3]); // dateProduction
            $('#edit-dateExpiry').val(data[4]); // dateExpiry
            $('#edit-qty').val(data[5]); // qty
            $('#edit-loteNumber').val(data[6]); // loteNumber
            $('#edit-purchasePrice').val(data[7]); // purchasePrice
            $('#edit-salePrice').val(data[8]); // salePrice
            $('#edit-registationDate').val(data[9]); // registationDate
            $('#edit-description').val(data[10]); // description
            $('#edit-user').val(data[11]); // user_id
            $('#modalEditMedication').modal('show');
        } else if (action === "delete") {
            $('#delete-medicationid').val(data[0]);
            $('#delete-username').text(data[1]);
            $('#modalDeleteMedication').modal('show');
        }
    });



    //adicionar novo usuário
    // Abrir modal de adicionar
    $('#btnAddUser').on('click', function() {
        $('#formAddUser')[0].reset(); // limpa os campos
        $('#modalAddUser').modal('show');
    });




    $('#formAddUser').on('submit', function(e) {
        e.preventDefault();

        const payload = {
            action: "add",
            username: $('#add-username').val(),
            password: $('#add-password').val(),
            employee_id: Number($('#add-employee_id').val()),
            role_id: Number($('#add-role_id').val())
        };

        fetch("routes/userRoutes.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalAddUser').modal('hide');
                    loadMedications(); // recarrega a tabela
                    swal("Sucesso!", "Usuário adicionado.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao adicionar usuário:", err));
    });

    // Submissão do formulário de edição de medicamento
    $('#formEditMedication').on('submit', function(e) {
        e.preventDefault();

        const payload = {
            action: "update",
            id: Number($('#edit-medicationid').val()),
            name: $('#edit-name').val(),
            type: $('#edit-type').val(),
            dateProduction: $('#edit-dateProduction').val(),
            dateExpiry: $('#edit-dateExpiry').val(),
            qty: Number($('#edit-qty').val()),
            loteNumber: Number($('#edit-loteNumber').val()),
            purchasePrice: parseFloat($('#edit-purchasePrice').val()),
            salePrice: parseFloat($('#edit-salePrice').val()),
            registationDate: $('#edit-registationDate').val(),
            description: $('#edit-description').val(),
            user_id: Number($('#edit-user').val())
        };

        console.log("Payload enviado:", payload);

        fetch("routes/medicationRoutes.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalEditMedication').modal('hide');
                    loadMedications(); // Função para recarregar a tabela
                    swal("Sucesso!", "Medicamento atualizado com sucesso.", "success");
                } else {
                    swal("Erro!", data.message || "Ocorreu um erro ao atualizar o medicamento.",
                        "error");
                }
            })
            .catch(err => {
                console.error("Erro ao atualizar medicamento:", err);
                swal("Erro!", "Falha na comunicação com o servidor.", "error");
            });
    });



    // Confirmar delete
    $('#confirmDeleteMedication').on('click', function() {
        const medicationId = Number($('#delete-medicationid').val()); // garante que é número

        fetch("routes/medicationRoutes.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    action: "delete",
                    id: medicationId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalDeleteMedication').modal('hide');
                    loadMedications(); // recarrega a tabela
                    swal("Deletado!", "Medicamento excluído.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao deletar Medicamento:", err));
    });
})
</script>