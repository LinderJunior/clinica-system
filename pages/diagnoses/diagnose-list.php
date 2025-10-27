<?php 

include_once __DIR__ . './../../src/components/header.php';

?>

<div class="pcoded-content">

    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h5 class="mb-0">Gestão de Consultas
                    </h5>
                    <!-- <button class="btn btn-mat waves-effect waves-light btn-success" id="btnAddUser">Novo Registo

                        <i class="icofont icofont-plus"></i>
                    </button> -->
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
                                    <span>Gestão centralizada de pacientes</span>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table id="userTable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">ID</th>
                                                    <th>ID_Consulta</th>
                                                    <th>ID_Doctor</th>
                                                    <th>Detalhes</th>
                                                    <th>Ficheiro</th>
                                                    <th style="width: 180px; text-align:center;">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <?php include_once __DIR__ . '/diagnose-modal.php'; ?>
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
    function loadConsults() {
        fetch("routes/diagnosisRoutes.php")
            .then(res => res.json())
            .then(data => {
                console.log("Dados recebidos:", data);
                if (data.status === "success" && Array.isArray(data.data)) {
                    table.clear();

                    data.data.forEach(consult => {
                        table.row.add([
                            consult.id, // ID
                            consult.consult_id ?? "—", // Paciente
                            consult.doctor_id ?? "—", // Doctor
                            consult.details ?? "—", // Data
                            consult.file ?? "—", // Hora
                            null // Botões de ação
                        ]);
                    });

                    table.draw();
                } else {
                    console.warn("Resposta inválida do servidor:", data);
                }
            })
            .catch(err => console.error("Erro ao carregar consultas:", err));
    }


    loadConsults();

    // Função genérica de ação
    $('#userTable tbody').on('click', '.action', function() {
        const action = $(this).data('action');
        const data = table.row($(this).parents('tr')).data();

        if (action === "view") {
            // IDs baseados na estrutura do modalViewMedication

            console.log("🔍 Dados completos da linha:", data);

            // // Baseado na ordem do row.add
            $('#view_id').val(data[0]); // ID
            $('#view_consult_id').val(data[1]); // Data (ou código consulta)
            $('#view_doctor_id').val(data[2]); // Hora (ou código paciente)
            $('#view_details').val(data[3]); // Detalhes
            $('#view_file').val(data[4]); // Ficheiro
            $('#view_file_link').attr('href', data[4]); // Link para abrir o
            $('#viewConsultModal').modal('show');


        } else if (action === "edit") {
            $('#edit-diagnosisid').val(data[0]); // id
            $('#edit-details').val(data[1]); // details
            $('#edit-file').val(data[2]); // file
            $('#edit-consult_id').val(data[3]); // consult_id
            $('#edit-doctor_id').val(data[4]); // doctor_id
            $('#modalEditDiagnosis').modal('show');
        } else if (action === "delete") {
            $('#delete-consultid').val(data[0]);
            $('#delete-username').text(data[1]);
            $('#modalDeleteConsult').modal('show');
        }
    });


    // 🔹 Submissão da edição
    $('#formEditDiagnosis').on('submit', function(e) {
        e.preventDefault();

        const payload = {
            action: "update",
            id: Number($('#edit-diagnosisid').val()),
            details: $('#edit-details').val(),
            file: $('#edit-file').val(),
            consult_id: parseInt($('#edit-consult_id').val()),
            doctor_id: parseInt($('#edit-doctor_id').val())
        };

        console.log("Payload enviado:", payload);

        fetch("routes/diagnosisRoutes.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalEditDiagnosis').modal('hide');
                    loadConsults(); // função que recarrega a lista
                    swal("Sucesso!", "Diagnóstico atualizado com sucesso.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao atualizar diagnóstico:", err));
    });


    // Confirmar delete
    $('#confirmDeleteConsult').on('click', function() {
        const medicationId = Number($('#delete-consultid').val()); // garante que é número

        fetch("routes/diagnosisRoutes.php", {
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
                    $('#modalDeleteConsult').modal('hide');
                    loadConsults(); // recarrega a tabela
                    swal("Deletado!", "Medicamento excluído.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao deletar Medicamento:", err));
    });
})
</script>