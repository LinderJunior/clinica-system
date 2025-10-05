<?php 

include_once __DIR__ . './../../src/components/header.php';

?>

<div class="pcoded-content">

    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h5 class="mb-0">Gestão de Medicamentos
                    </h5>
                    <button class="btn btn-mat waves-effect waves-light btn-success" id="btnAddUser">Novo Registo

                        <i class="icofont icofont-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Tabela de Pacientes</h5>
                                    <span>Gestão centralizada de usuários</span>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table id="userTable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">ID</th>
                                                    <th>Nome</th>
                                                    <!-- <th>Tipo</th>
                                                    <th>Data de Produção</th>
                                                    <th>Data de validade</th>
                                                    <th>Quantidade</th>
                                                    <th>Numero de Lote</th>
                                                    <th>Preço de compra</th>
                                                    <th>Preço de venda</th>
                                                    <th>Data de registo</th>
                                                    <th>Descrição</th>
                                                    <th>Registado por</th> -->
                                                    <th style="width: 180px; text-align:center;">Ações</th>
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
        <div id="styleSelector"></div>
    </div>
</div>


<style>
#userTable th:last-child,
#userTable td:last-child {
    width: 180px;
    text-align: center;
    white-space: nowrap;
}

/* Botões pequenos com menos padding */
#userTable .btn-sm {
    padding: 2px 6px;
    font-size: 0.85rem;
}
</style>



<script>
$(document).ready(function() {

    // Inicializa DataTable
    const table = $('#userTable').DataTable({
        responsive: true,
        autoWidth: false, // importante
        paging: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        ordering: true,
        info: true,
        searching: true,
        order: [
            [0, "asc"]
        ],
        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent: `


            <button class="btn waves-effect waves-light btn-warning action" data-action="view" title="Visualizar">
                <i class="icofont icofont-info-square"></i>
            </button>
            <button class="btn waves-effect waves-light btn-primary action" data-action="edit" title="Editar">
                <i class="icofont icofont-ui-edit"></i>
            </button>
            <button class="btn waves-effect waves-light btn-danger action" data-action="delete" title="Deletar">
                <i class="icofont icofont-ui-delete"></i>
            </button>

            `
        }],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "Nenhum usuário encontrado",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Nenhum dado disponível",
            infoFiltered: "(filtrado de _MAX_ registros no total)",
            search: "Pesquisar:",
            paginate: {
                first: "Primeiro",
                last: "Último",
                next: "Próximo",
                previous: "Anterior"
            }
        }
    });

    // Carrega usuários via API
    function loadMedications() {
        fetch("routes/medicationRoutes.php")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    table.clear();
                    data.data.forEach(medication => table.row.add([
                        medication.id,
                        // medication.name,
                        // medication.type,
                        // medication.dateProduction,
                        // medication.dateExpiry,
                        // medication.qty,
                        // medication.loteNumber,
                        // medication.purchasePrice,
                        // medication.salePrice,
                        // medication.registationDate,
                        // medication.description,
                        // medication.user_id,
                        null
                    ]));
                    table.draw();
                }
            }).catch(err => console.error(err));
    }

    loadMedications();

    // Função genérica de ação
    $('#userTable tbody').on('click', '.action', function() {
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