<?php include_once __DIR__ . './../../src/components/header.php'; ?>

<div class="pcoded-content">

    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Gestão de Funcionários
                </h5>
                <!-- <button class="btn btn-success btn-sm d-flex align-items-center shadow-sm" id="btnAddEmployee"
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
                                <h6 class="text-secondary mb-0 text-uppercase">Tabela de Funcionários</h6>
                                <small class="text-muted">Visualização geral dos funcionários</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="employeeTable" class="table table-sm table-striped table-hover align-middle"
                                    style="width:100%">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>B.I</th>
                                            <th>Telefone</th>
                                            <!-- <th>Posições</th> -->
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php include_once __DIR__ . '/employee-modal.php'; ?>
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

#employeeTable {
    border: 1px solid #dee2e6;
}

#employeeTable .btn-sm {
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

#employeeTable thead th {
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


/**Estilizacao de Botoes */

/* ---------- Botões da tabela de médicos ---------- */
#employeeTable .btn-sm {
    padding: 6px 10px;
    font-size: 0.85rem;
    margin: 0 3px;
    border-radius: 6px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

#employeeTable .btn-sm i {
    margin-right: 4px;
    font-size: 1rem;
}

/* Cores dos botões */
.btn-success {
    background-color: #28a745 !important;
    border: none;
    color: #fff;
}

.btn-success:hover {
    background-color: #218838 !important;
    transform: scale(1.05);
}

.btn-info {
    background-color: #17a2b8 !important;
    border: none;
    color: #fff;
}

.btn-info:hover {
    background-color: #138496 !important;
    transform: scale(1.05);
}

.btn-primary {
    background-color: #6c757d !important;
    border: none;
    color: #fff;
}

.btn-primary:hover {
    background-color: #5a6268 !important;
    transform: scale(1.05);
}

.btn-danger {
    background-color: #dc3545 !important;
    border: none;
    color: #fff;
}

.btn-danger:hover {
    background-color: #c82333 !important;
    transform: scale(1.05);
}

.btn-warning {
    background-color: #ffc107 !important;
    border: none;
    color: #212529;
}

.btn-warning:hover {
    background-color: #e0a800 !important;
    transform: scale(1.05);
}
</style>

<script>
$(document).ready(function() {
    let employeesData = [];
    let positions = [];

    // Inicializa DataTable
    const table = $('#employeeTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        dom: 'Bfrtip',
        buttons: [{
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'Exportar para PDF',
                className: 'btn btn-danger btn-sm',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Relatório de Funcionários'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Exportar para Excel',
                className: 'btn btn-success btn-sm',
                title: 'Relatório de Funcionários'
            }
        ],
        columnDefs: [{
            targets: -1,
            data: null,
            orderable: false,
            className: "text-center",
            defaultContent: `

                <button class="btn btn-sm btn-success action" data-action="marcar">
                    <i class="icofont icofont-plus"></i> AGENDAR CONSULTA
                </button>
                <button class="btn btn-sm btn-info action" data-action="view">
                    <i class="icofont icofont-eye"></i> VER CONSULTAS
                </button>
                <button class="btn btn-sm btn-info btn-icon action" data-action="manage" title="Gerir Consulta">
                    <i class="icofont icofont-eye" style="font-size: 1.5rem;"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-icon action" data-action="edit" title="Editar">
                    <i class="icofont icofont-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-icon action" data-action="delete" title="Eliminar">
                    <i class="icofont icofont-trash"></i>
                </button>
            `
        }],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "Nenhum funcionário encontrado",
            info: "Mostrando _START_ a _END_ de _TOTAL_ funcionários",
            infoEmpty: "Sem dados disponíveis",
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

    // Função para carregar médicos
    function loadDoctors() {
        fetch("routes/employeeRoutes.php?route=employees&doctors=true")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    employeesData = data.data;

                    table.clear();
                    data.data.forEach(employee => {
                        table.row.add([
                            employee.id,
                            employee.name,
                            employee.bi,
                            employee.phoneNumber,
                            // employee.positions.map(p => p.type || p.position_id).join(", "),
                            null
                        ]);
                    });
                    table.draw();
                }
            })
            .catch(err => console.error(err));
    }

    loadDoctors();

    // Renderiza lista de posições no modal de edição
    function renderPositions() {
        const list = $('#positionsList');
        list.empty();

        positions.forEach(pos => {
            const li = `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${pos.name}
                    <button type="button" class="btn btn-sm btn-danger" onclick="removePosition(${pos.id})">Remover</button>
                </li>
            `;
            list.append(li);
        });
    }

    // Handler para ações da tabela
    $('#employeeTable tbody').on('click', '.action', function() {
        const action = $(this).data('action');
        const data = table.row($(this).parents('tr')).data();
        const employeeId = data[0];
        const employee = employeesData.find(e => e.id == employeeId);

        if (!employee && action !== "manage") return;

        switch (action) {
            case "view":
                $('#view-name').text(employee.name);
                $('#view-employee_id').text(employee.id);
                $('#view-role').text(employee.positions.map(p => p.type || p.position_id).join(", "));
                $('#modalViewUser').modal('show');
                break;

            case "edit":
                $('#edit-employeeid').val(employee.id);
                $('#edit-nome').val(employee.name);
                $('#edit-bi').val(employee.bi);
                $('#edit-telefone').val(employee.phoneNumber);

                positions = employee.positions.map(p => ({
                    id: parseInt(p.id || p.position_id),
                    name: p.type || p.position_id
                }));
                renderPositions();

                $('#modalEditEmployee').modal('show');
                break;

            case "delete":
                $('#delete-employeeid').val(employee.id);
                $('#delete-username').text(employee.name);
                $('#modalDeleteEmployee').modal('show');
                break;

            case "manage":
                window.location.href = `link.php?route=20&id=${employeeId}`;
                break;
        }
    });

    // Botão de adicionar novo funcionário
    $('#btnAddEmployee').on('click', function() {
        $('#formAddUser')[0].reset();
        $('#modalAddUser').modal('show');
    });

    // Submissão do formulário de edição
    $('#formEditEmployee').on('submit', function(e) {
        e.preventDefault();

        const payload = {
            action: "update",
            id: Number($('#edit-employeeid').val()),
            name: $('#edit-nome').val(),
            bi: $('#edit-bi').val(),
            phoneNumber: $('#edit-telefone').val(),
            positionIds: positions.map(p => p.id)
        };

        fetch("routes/employeeRoutes.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalEditEmployee').modal('hide');
                    loadDoctors();
                    swal("Sucesso!", "Funcionário atualizado com sucesso.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao atualizar funcionário:", err));
    });

    // Confirmar delete
    $('#confirmDeleteEmployee').on('click', function() {
        const employeeId = Number($('#delete-employeeid').val());

        fetch("routes/employeeRoutes.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    action: "delete",
                    id: employeeId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    $('#modalDeleteEmployee').modal('hide');
                    loadDoctors();
                    swal("Deletado!", "Funcionário excluído.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao deletar funcionário:", err));
    });
});
</script>