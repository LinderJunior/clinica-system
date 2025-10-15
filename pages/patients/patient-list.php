<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">

    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Gestão de Pacientes
                </h5>
                <button class="btn btn-success btn-sm d-flex align-items-center shadow-sm" id="btnAddUser"
                    style="font-size: 0.9rem; padding: 0.35rem 0.7rem;">
                    <i class="icofont icofont-plus mr-1" style="font-size: 1rem;"></i>
                    Novo Registo
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
                                <h6 class="text-secondary mb-0 text-uppercase">Tabela de Pacientes</h6>
                                <small class="text-muted">Visualização geral de pacientes registados</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="patientTable" class="table table-sm table-striped table-hover align-middle"
                                    style="width:100%">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Data de Nascimento</th>
                                            <th>B.I</th>
                                            <th>Provincia</th>
                                            <th>Cidade</th>
                                            <th>Bairro</th>
                                            <th>Telefone</th>
                                            <th>WhatsApp</th>
                                            <th class="text-center">Ações</th>
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

#patientTable {
    border: 1px solid #dee2e6;
}

/* ---------- Ícones e botões ---------- */
#patientTable .btn-sm {
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
#patientTable thead th {
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
</style>

<script>
$(document).ready(function() {
    const table = $('#patientTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        language: {
            lengthMenu: "Mostrar _MENU_ pacientes",
            zeroRecords: "Nenhum paciente encontrado",
            info: "Mostrando _START_ a _END_ de _TOTAL_ pacientes",
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

    // Carrega pacientes
    function loadPatients() {
        fetch("routes/patientRoutes.php")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    table.clear();
                    data.data.forEach(patient => {
                        table.row.add([
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
                        ]);
                    });
                    table.draw();
                }
            }).catch(err => console.error(err));
    }

    loadPatients();


    // Função genérica de ação
    $('#patientTable tbody').on('click', '.action', function() {
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