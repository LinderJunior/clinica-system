<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">
    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Gestão de Consultas
                </h5>
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
                                <small class="text-muted">Visualização de consultas registadas</small>
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

#consultTable {
    border: 1px solid #dee2e6;
}

/* ---------- Botões e ícones ---------- */
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

/* ---------- Badges ---------- */
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

/* Centraliza colunas */
#consultTable thead th {
    text-align: center !important;
    vertical-align: middle;
}





/* BOTOES MARCAR CONSULTA E VER CONSULTA */

.btn {
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    padding: 10px 16px;
    border: none;
    cursor: pointer;
}

/* Padronizar tamanho dos botões personalizados */
.btn-ver,
.btn-marcar {
    min-width: 130px;
    /* define uma largura mínima igual aos outros botões */
    height: 38px;
    /* altura proporcional à classe .btn-sm */
    font-size: 14px;
    /* texto uniforme */
    font-weight: 500;
    border-radius: 6px;
    /* bordas suaves como os outros */
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Botão MARCAR CONSULTA */
.btn-marcar {
    background: linear-gradient(135deg, #28a745, #34d058);
    color: white;
    box-shadow: 0 4px 10px rgba(40, 167, 69, 0.4);
}

.btn-marcar:hover {
    background: linear-gradient(135deg, #218838, #2ebf4f);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(40, 167, 69, 0.5);
}

/* Botão VER CONSULTA */
.btn-ver {
    background: linear-gradient(135deg, #007bff, #3399ff);
    color: white;
    box-shadow: 0 4px 10px rgba(0, 123, 255, 0.4);
}

.btn-ver:hover {
    background: linear-gradient(135deg, #0069d9, #2a8cff);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 123, 255, 0.5);
}

/* Ícones */
.btn i {
    margin-right: 6px;
    font-size: 15px;
}

/* Espaçamento entre botões */
.action {
    margin-right: 10px;
}
</style>









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
              

                <button class="btn btn-sm btn-ver action" data-action="manage" title="Ver Consultas">
                    <i class="icofont icofont-eye"></i>Detalhes da consulta
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

    // Pegar parâmetro id da URL (paciente)
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }


    function loadConsults() {
        const patientId = getQueryParam('id'); // id do paciente na URL

        let url = "routes/index.php?route=consults";
        let fetchOptions = {};

        if (patientId) {
            // buscar só desse paciente via POST
            fetchOptions = {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    action: "searchByPatient",
                    patient_id: Number(patientId)
                })
            };
        } else {
            // buscar todas as consultas via GET
            fetchOptions = {
                method: "GET"
            };
        }

        fetch(url, fetchOptions)
            .then(res => res.json())
            .then(data => {
                table.clear();
                if (data.status === "success" && Array.isArray(data.data)) {
                    data.data.forEach(consult => {
                        // Converter a data de YYYY-MM-DD -> DD/MM/YYYY
                        let formattedDate = "";
                        if (consult.date) {
                            const parts = consult.date.split("-");
                            if (parts.length === 3) {
                                formattedDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
                            } else {
                                formattedDate = consult.date; // fallback
                            }
                        }

                        const statusLabel = consult.status == 1 ?
                            '<span class="badge badge-success">Concluída</span>' :
                            '<span class="badge badge-warning">Pendente</span>';

                        table.row.add([
                            consult.id,
                            formattedDate, // ✅ data formatada no estilo mocambicano
                            consult.time,
                            consult.type,
                            statusLabel,
                            consult.patient_name || consult.patient_id,
                            consult.doctor_name || consult.doctor_id,
                            null
                        ]);
                    });
                }
                table.draw();
            })
            .catch(err => console.error("Erro ao carregar consultas:", err));
    }

    loadConsults();


    $('#consultTable tbody').on('click', '.action', function() {
        const action = $(this).data('action');
        const data = table.row($(this).parents('tr')).data();
        if (action === "edit") {
            const consultId = data[0];
            const formattedDate = data[1];
            const dateParts = formattedDate.split("/");
            const isoDate = dateParts.length === 3 ? `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}` :
                "";

            // Preenche campos da consulta
            $('#edit-consultid').val(consultId);
            $('#edit-date').val(isoDate);
            $('#edit-time').val(data[2]);
            $('#edit-type').val(data[3]);
            // Recupera o status e define o valor do select corretamente
            let statusValue = "0"; // valor padrão
            const statusText = (data[4] || '').trim().toLowerCase();

            if (statusText === "pendente") statusValue = "0";
            else if (statusText === "concluída" || statusText === "concluida") statusValue = "1";
            else if (statusText === "cancelada") statusValue = "2";

            $('#edit-status').val(statusValue);




            // Carregar pacientes dinamicamente
            const patientSelect = document.getElementById("edit-patient_id");
            const currentPatient = data[5]; // nome do paciente atual (exibido na tabela)

            fetch("routes/patientRoutes.php")
                .then(res => res.json())
                .then(pData => {
                    patientSelect.innerHTML = '<option value="">Selecione um Paciente</option>';
                    if (pData.status === "success" && Array.isArray(pData.data)) {
                        pData.data.forEach(p => {
                            const opt = document.createElement("option");
                            opt.value = p.id;
                            opt.textContent = p.name || p.nome;
                            patientSelect.appendChild(opt);
                        });

                        // Selecionar o paciente atual
                        const selected = Array.from(patientSelect.options).find(
                            opt => opt.textContent.trim() === currentPatient.trim()
                        );
                        if (selected) {
                            selected.selected = true;
                        }
                    } else {
                        patientSelect.innerHTML =
                            '<option value="">Nenhum paciente encontrado</option>';
                    }
                })
                .catch(err => console.error("Erro ao carregar pacientes:", err));

            // Carregar médicos dinamicamente (mesmo princípio, se quiser)
            // Carregar médicos dinamicamente
            const doctorSelect = document.getElementById("edit-doctor_id");
            const currentDoctor = data[6]; // nome do médico atual

            fetch("routes/employeeRoutes.php?doctors=true")
                .then(res => res.json())
                .then(dData => {
                    doctorSelect.innerHTML = '<option value="">Selecione um Médico</option>';

                    if (dData.status === "success" && Array.isArray(dData.data)) {
                        dData.data.forEach(m => {
                            const opt = document.createElement("option");
                            opt.value = m.id;
                            opt.textContent = m.name || m.nome;
                            doctorSelect.appendChild(opt);
                        });

                        // Seleciona o médico correspondente à consulta atual
                        const selected = Array.from(doctorSelect.options).find(
                            opt => opt.textContent.trim().toLowerCase() === currentDoctor.trim()
                            .toLowerCase()
                        );
                        if (selected) {
                            selected.selected = true;
                        }
                    } else {
                        doctorSelect.innerHTML =
                            '<option value="">Nenhum médico encontrado</option>';
                    }
                })
                .catch(err => console.error("Erro ao carregar médicos:", err));


            // Exibir modal
            $('#modalEditConsult').modal('show');
        } else if (action === "delete") {
            $('#delete-consultid').val(data[0]);
            $('#delete-username').text(data[1]);
            $('#modalDeleteConsult').modal('show');
        } else if (action === "manage") {
            const consultId = data[0];
            window.location.href = `link.php?route=17&id=${consultId}`;
        } else if (action === "pdf") {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            doc.setFontSize(16);
            doc.text("Detalhes da consulta", 105, 20, null, null, "center");
            doc.setDrawColor(0, 123, 255);
            doc.rect(15, 30, 180, 100, "S");
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
            window.open(doc.output('bloburl'), '_blank');
        }
    });


    $('#confirmDeleteConsult').on('click', function() {
        const consultId = Number($('#delete-consultid').val());
        fetch("routes/index.php?route=consults", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    action: "delete",
                    id: consultId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalDeleteConsult').modal('hide');
                    loadConsults();
                    swal("Deletado!", "Consulta excluída.", "success");
                } else swal("Erro!", data.message, "error");
            }).catch(err => console.error(err));
    });





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

        fetch("routes/index.php?route=consults", {
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
                    loadConsults();
                    Swal.fire({
                        title: "Sucesso!",
                        text: "Consulta atualizada com sucesso.",
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                } else {
                    Swal.fire({
                        title: "Erro!",
                        text: data.message,
                        icon: "error",
                        confirmButtonText: "Fechar"
                    });
                }
            })
            .catch(err => {
                console.error("Erro ao atualizar consulta:", err);
                Swal.fire({
                    title: "Erro!",
                    text: "Falha na comunicação com o servidor.",
                    icon: "error",
                    confirmButtonText: "Fechar"
                });
            });
    });





});
</script>