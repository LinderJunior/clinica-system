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
                                    <span>Gestão centralizada de pacientes</span>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table id="consultTable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">ID</th>
                                                    <th>Data</th>
                                                    <th>Hora</th>
                                                    <th>Tipo de consulta</th>
                                                    <th>Status</th>
                                                    <th>Paciente</th>
                                                    <th>Doctor</th>
                                                    <th style="width: 180px; text-align:center;">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <?php include_once __DIR__ . '/consult-modal.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector"></div>
    </div>
</div>

<style>
#consultTable th:last-child,
#consultTable td:last-child {
    width: 180px;
    text-align: center;
    white-space: nowrap;
}

/* Botões pequenos com menos padding */
#consultTable .btn-sm {
    padding: 2px 6px;
    font-size: 0.85rem;
}
</style>


<script>
$(document).ready(function() {

    // Inicializa DataTable
    const table = $('#consultTable').DataTable({
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
                <button class="btn btn-sm btn-info action" data-action="manage" title="Gerir Consulta">
                    <i class="icofont icofont-medical-sign"></i> Gerir
                </button>
                <button class="btn btn-sm btn-primary action" data-action="edit" title="Editar">
                    <i class="icofont icofont-ui-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger action" data-action="delete" title="Deletar">
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
        fetch("routes/consultRoutes.php")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    table.clear();
                    data.data.forEach(consult => table.row.add([
                        consult.id,
                        consult.date,
                        consult.time,
                        consult.type,
                        consult.status,
                        consult.patient_id,
                        consult.doctor_id,
                        null
                    ]));
                    table.draw();
                }
            }).catch(err => console.error(err));
    }

    loadConsults();

    // Função genérica de ação
    $('#consultTable tbody').on('click', '.action', function() {
        const action = $(this).data('action');
        const data = table.row($(this).parents('tr')).data();

        if (action === "view") {
            // IDs baseados na estrutura do modalViewMedication
            $('#view-date').text(data[1]); // date
            $('#view-time').text(data[2]); // time
            $('#view-type').text(data[3]); // type
            $('#view-status').text(data[4] == 0 ? 'Pendente' : 'Concluída'); // status
            $('#view-patient_id').text(data[5]); // patient_id
            $('#view-doctor_id').text(data[6]); // doctor_id
            $('#modalViewConsult').modal('show');
        } else if (action === "edit") {
            $('#edit-consultid').val(data[0]); // id
            $('#edit-date').val(data[1]); // date
            $('#edit-time').val(data[2]); // time
            $('#edit-type').val(data[3]); // type
            $('#edit-status').val(data[4]); // status
            $('#edit-patient_id').val(data[5]); // patient_id
            $('#edit-doctor_id').val(data[6]); // doctor_id
            $('#modalEditConsult').modal('show');
        } else if (action === "delete") {
            $('#delete-consultid').val(data[0]);
            $('#delete-username').text(data[1]);
            $('#modalDeleteConsult').modal('show');
        } else if (action === "manage") {
            const consultId = data[0];
            window.location.href = `link.php?route=17&id=${consultId}`;
            return;
        }



    });


    // 🔹 Submissão da edição
    $('#formEditConsult').on('submit', function(e) {
        e.preventDefault();

        const payload = {
            action: "update",
            id: Number($('#edit-consultid').val()),
            date: $('#edit-date').val(),
            time: $('#edit-time').val(),
            type: $('#edit-type').val(),
            status: parseInt($('#edit-status').val()),
            patient_id: parseInt($('#edit-patient_id').val()),
            doctor_id: parseInt($('#edit-doctor_id').val())
        };

        console.log("Payload enviado:", payload);

        fetch("routes/consultRoutes.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalEditConsult').modal('hide');
                    loadConsults(); // função que recarrega a tabela
                    swal("Sucesso!", "Consulta atualizada com sucesso.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao atualizar consulta:", err));
        swal("Erro!", "Falha na comunicação com o servidor.", "error");
    });




    // Confirmar delete
    $('#confirmDeleteConsult').on('click', function() {
        const medicationId = Number($('#delete-consultid').val()); // garante que é número

        fetch("routes/consultRoutes.php", {
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