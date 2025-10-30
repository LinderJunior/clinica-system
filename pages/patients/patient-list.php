<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">

    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Gestão de Pacientes
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

                <button class="btn btn-sm btn-ver action" data-action="ver-consultas" title="Ver Consultas">
                    <i class="icofont icofont-eye"></i> Ver Consultas
                </button>
                <button class="btn btn-sm btn-marcar action" data-action="agendar-consulta" title="Agendar Consulta">
                <i class="icofont icofont-calendar"></i> Agendar
                </button>
                <button class="btn btn-sm btn-primary btn-icon action" data-action="edit" title="Editar">
                        <i class="icofont icofont-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-icon action" data-action="delete" title="Eliminar">
                        <i class="icofont icofont-trash"></i>
                <button class="btn btn-sm btn-info btn-icon action" data-action="pdf" title="PDF">
                    <i class="icofont icofont-file-pdf"></i>
                </button>
            
            `
        }]
    });

    function loadPatients() {
        fetch("routes/patientRoutes.php")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    table.clear();
                    data.data.forEach(patient => {
                        // Converter a data de YYYY-MM-DD -> DD/MM/YYYY
                        let formattedDate = "";
                        if (patient.dateBirth) {
                            const parts = patient.dateBirth.split("-");
                            if (parts.length === 3) {
                                formattedDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
                            } else {
                                formattedDate = patient.dateBirth; // fallback
                            }
                        }



                        // Converter o valor de WhatsApp
                        let whatsappText = "";
                        if (patient.iswhatsapp == 1) {
                            whatsappText = "Sim";
                        } else if (patient.iswhatsapp == 2) {
                            whatsappText = "Não";
                        } else {
                            whatsappText = "-"; // caso venha nulo ou outro valor
                        }

                        table.row.add([
                            patient.id,
                            patient.name,
                            formattedDate,
                            patient.bi,
                            patient.province,
                            patient.city,
                            patient.neighborhood,
                            patient.phoneNumber,
                            whatsappText, // mostra texto no lugar do número
                            null // coluna de ações
                        ]);
                    });
                    table.draw();
                }
            })
            .catch(err => console.error("Erro ao carregar pacientes:", err));
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

            // Converte DD/MM/YYYY → YYYY-MM-DD para flatpickr (internamente)
            const dateParts = data[2].split("/");
            const isoDate = dateParts.length === 3 ? `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}` :
                "";
            $('#edit-datanascimento').val(isoDate);

            $('#edit-bi').val(data[3]);
            $('#edit-provincia').val(data[4]);
            $('#edit-cidade').val(data[5]);
            $('#edit-bairro').val(data[6]);
            $('#edit-telefone').val(data[7]);

            // Recupera valor de WhatsApp e define o select corretamente
            const whatsappValue = data[8] == "1" ? "1" : "2"; // 1=Sim, 2=Não
            $('#edit-iswhatsapp').val(whatsappValue);

            $('#modalEditPatient').modal('show');

        } else if (action === "delete") {
            $('#delete-patientid').val(data[0]);
            $('#delete-username').text(data[1]);
            $('#modalDeletePatient').modal('show');
        } else if (action === "ver-consultas") {
            const patientId = data[0];
            window.location.href = `link.php?route=7&id=${patientId}`;
            return;
        } else if (action === "agendar-consulta") {
            const patientId = data[0];
            window.location.href = `link.php?route=18&patient_id=${patientId}`;
            return;
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
            dateBirth: $('#edit-datanascimento').val(), // flatpickr envia ISO (YYYY-MM-DD)
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
                    Swal.fire({
                        icon: "success",
                        title: "Cadastro realizado!",
                        text: data.message ||
                            "O paciente foi registado com sucesso linder.",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didClose: () => {
                            // Redirecionar após fechar
                            window.location.href = "link.php?route=3";
                        }
                    });
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao atualizar paciente:", err));
    });


    $('#patientTable tbody').on('click', '.action', function() {
        const action = $(this).data('action');
        const data = table.row($(this).parents('tr')).data();

        if (action === "pdf") {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            doc.setFontSize(16);
            doc.text("Detalhes do Paciente", 105, 20, null, null, "center");

            // Borda
            doc.setDrawColor(0, 123, 255);
            doc.rect(15, 30, 180, 100, "S");

            // Conteúdo
            const startY = 40;
            const lineHeight = 10;
            const details = [
                `ID: ${data[0]}`,
                `Nome: ${data[1]}`,
                `Data de Nascimento: ${data[2]}`,
                `B.I: ${data[3]}`,
                `Província: ${data[4]}`,
                `Cidade: ${data[5]}`,
                `Bairro: ${data[6]}`,
                `Telefone: ${data[7]}`
            ];
            details.forEach((line, i) => doc.text(line, 20, startY + i * lineHeight));

            // Abrir em nova aba para visualizar
            const blobUrl = doc.output('bloburl');
            window.open(blobUrl, '_blank');
        }
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