<?php 

include_once __DIR__ . './../../src/components/header.php';

?>

<div class="pcoded-content">

    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h5 class="mb-0">Gestão de Pacientes</h5>
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
                                                    <th>Data de Nascimento</th>
                                                    <th>B.I</th>
                                                    <th>Provincia</th>
                                                    <th>Cidade</th>
                                                    <th>Bairro</th>
                                                    <th>Numero de telefone</th>
                                                    <th>WhatsApp</th>
                                                    <th style="width: 180px; text-align:center;">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <?php include_once __DIR__ . '/patient-modal.php'; ?>


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
    function loadPatients() {
        fetch("routes/patientRoutes.php")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    table.clear();
                    data.data.forEach(patient => table.row.add([
                        patient.id,
                        patient.name,
                        patient.dateBirth,
                        patient.bi,
                        patient.province,
                        patient.city,
                        patient.neighborhood,
                        patient.phoneNumber,
                        patient.iswhatsapp,
                        null
                    ]));
                    table.draw();
                }
            }).catch(err => console.error(err));
    }

    loadPatients();

    // Função genérica de ação
    $('#userTable tbody').on('click', '.action', function() {
        const action = $(this).data('action');
        const data = table.row($(this).parents('tr')).data();

        if (action === "view") {
            $('#view-name').text(data[1]);
            $('#view-employee_id').text(data[2]);
            $('#view-role').text(data[3]);
            $('#modalViewUser').modal('show');

        } else if (action === "edit") {
            $('#edit-patientid').val(data[0]);
            $('#edit-nome').val(data[1]);
            $('#edit-datanascimento').val(data[2]);
            $('#edit-bi').val(data[3]);
            $('#edit-provincia').val(data[4]);
            $('#edit-cidade').val(data[5]);
            $('#edit-bairro').val(data[6]);
            $('#edit-telefone').val(data[7]);
            $('#edit-iswhatsapp').val(data[8]);
            $('#modalEditPatient').modal('show');

        } else if (action === "delete") {
            $('#delete-patientid').val(data[0]);
            $('#delete-username').text(data[1]);
            $('#modalDeletePatient').modal('show');
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
                    loadPatients(); // recarrega a tabela
                    swal("Sucesso!", "Usuário adicionado.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao adicionar usuário:", err));
    });


    // Submissão do Editar Paciente
    $('#formEditPatient').on('submit', function(e) {
        e.preventDefault();

        const payload = {
            action: "update",
            id: Number($('#edit-patientid').val()),
            name: $('#edit-nome').val(),
            dateBirth: $('#edit-datanascimento').val(),
            bi: $('#edit-bi').val(),
            province: $('#edit-provincia').val(),
            city: $('#edit-cidade').val(),
            neighborhood: $('#edit-bairro').val(),
            phoneNumber: $('#edit-telefone').val(),
            iswhatsapp: $('#edit-iswhatsapp').val()
        };

        console.log("Payload enviado:", payload);
        fetch("routes/patientRoutes.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalEditPatient').modal('hide');
                    loadPatients(); // recarrega a tabela
                    swal("Sucesso!", "Paciente atualizado com sucesso.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao atualizar paciente:", err));
    });




    // Confirmar delete
    $('#confirmDeletePatient').on('click', function() {
        const patientId = Number($('#delete-patientid').val()); // garante que é número

        fetch("routes/patientRoutes.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    action: "delete",
                    id: patientId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalDeletePatient').modal('hide');
                    loadPatients(); // recarrega a tabela
                    swal("Deletado!", "Paciente excluído.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao deletar Paciente:", err));
    });
})
</script>