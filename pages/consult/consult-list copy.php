<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">
    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Gestão de Consultas
                </h5>
                <!-- <button class="btn btn-success btn-sm d-flex align-items-center shadow-sm" id="btnAddUser"
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
                                <h6 class="text-secondary mb-0 text-uppercase">Tabela de Consultas</h6>
                                <small class="text-muted">Visualização geral de consultas registadas</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="consultTable" class="table table-sm table-striped table-hover align-middle"
                                    style="width:100%">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>ID</th>
                                            <th>Data</th>
                                            <th>Hora</th>
                                            <th>Tipo</th>
                                            <th>Status</th>
                                            <th>Paciente</th>
                                            <th>Doutor</th>
                                            <th class="text-center">Ações</th>
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
    background-color: #748595ff;
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

#consultTable {
    border: 1px solid #dee2e6;
}

/* ---------- Status visual ---------- */
.badge {
    font-size: 0.75rem;
    padding: 5px 8px;
    border-radius: 8px;
}

.badge-success {
    background-color: #28a745 !important;
}

.badge-warning {
    background-color: #ffc107 !important;
    color: #212529 !important;
}

/* ---------- Ícones e botões ---------- */
#consultTable .btn-sm {
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

/* ---------- Table ----------------- */

/* Centraliza os títulos das colunas */
#consultTable thead th {
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
    const table = $('#consultTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        language: {
            lengthMenu: "Mostrar _MENU_ consultas",
            zeroRecords: "Nenhuma consulta encontrada",
            info: "Mostrando _START_ a _END_ de _TOTAL_ consultas",
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
               <button class="btn btn-sm btn-info btn-icon action" data-action="manage" title="Gerir Consulta">
                    <i class="icofont icofont-eye" style="font-size: 1.5rem;"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-icon action" data-action="edit" title="Editar Consulta">
                    <i class="icofont icofont-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-icon action" data-action="delete" title="Eliminar Consulta">
                    <i class="icofont icofont-trash"></i>
                </button>
                <button class="btn btn-sm btn-info btn-icon action" data-action="pdf" title="PDF">
                    <i class="icofont icofont-file-pdf"></i>
                </button>

                
                
            `
        }]
    });

    // Carrega consultas
    function loadConsults() {
        fetch("routes/consultRoutes.php")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    table.clear();
                    data.data.forEach(consult => {
                        const statusLabel = consult.status == 1 ?
                            '<span class="badge badge-success">Concluída</span>' :
                            '<span class="badge badge-warning">Pendente</span>';

                        table.row.add([
                            consult.id,
                            consult.date,
                            consult.time,
                            consult.type,
                            statusLabel,
                            consult.patient_name || consult.patient_id,
                            consult.doctor_name || consult.doctor_id,
                            null
                        ]);
                    });
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

    $('#consultTable tbody').on('click', '.action', function() {
        const action = $(this).data('action');
        const data = table.row($(this).parents('tr')).data();

        if (action === "pdf") {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            doc.setFontSize(16);
            doc.text("Detalhes da consulta", 105, 20, null, null, "center");

            // Borda
            doc.setDrawColor(0, 123, 255);
            doc.rect(15, 30, 180, 100, "S");

            // Conteúdo
            const startY = 40;
            const lineHeight = 10;
            const details = [
                `ID: ${data[0]}`,
                `Data: ${data[1]}`,
                `Hora: ${data[2]}`,
                `Tipo: ${data[3]}`,
                `Status: ${data[4]}`,
                `Paciente: ${data[5]}`,
                `Doutor: ${data[6]}`
            ];
            details.forEach((line, i) => doc.text(line, 20, startY + i * lineHeight));

            // Abrir em nova aba para visualizar
            const blobUrl = doc.output('bloburl');
            window.open(blobUrl, '_blank');
        }
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