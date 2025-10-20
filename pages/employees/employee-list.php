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
                                            <th>Posições</th>
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
</style>

<script>
$(document).ready(function() {
    let employeesData = [];

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

    function loadEmployees() {
        fetch("routes/employeeRoutes.php")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    employeesData = data.data;

                    table.clear();
                    data.data.forEach(employee => table.row.add([
                        employee.id,
                        employee.name,
                        employee.bi,
                        employee.phoneNumber,
                        employee.positions.map(p => p.type).join(", "),
                        null
                    ]));
                    table.draw();
                }
            }).catch(err => console.error(err));
    }

    loadEmployees();




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
            const rowData = table.row($(this).parents('tr')).data();
            const employeeId = rowData[0];

            const employee = employeesData.find(e => e.id == employeeId);

            if (!employee) return;

            $('#edit-employeeid').val(employee.id);
            $('#edit-nome').val(employee.name);
            $('#edit-bi').val(employee.bi);
            $('#edit-telefone').val(employee.phoneNumber);

            positions = employee.positions.map(p => ({
                id: parseInt(p.id),
                name: p.type
            }));
            renderPositions();

            $('#modalEditEmployee').modal('show');
        } else if (action === "delete") {
            $('#delete-employeeid').val(data[0]);
            $('#delete-username').text(data[1]);
            $('#modalDeleteEmployee').modal('show');
        }
    });



    //adicionar novo usuário
    // Abrir modal de adicionar
    $('#btnAddUser').on('click', function() {
        $('#formAddUser')[0].reset(); // limpa os campos
        $('#modalAddUser').modal('show');
    });





    // Submissão do Editar Funcionário
    $('#formEditEmployee').on('submit', function(e) {
        e.preventDefault();

        const payload = {
            action: "update",
            id: Number($('#edit-employeeid').val()),
            name: $('#edit-nome').val(),
            bi: $('#edit-bi').val(),
            phoneNumber: $('#edit-telefone').val(),
            positionIds: positions.map(p => p.id) // só IDs

        };

        console.log("Payload enviado:", payload);

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
                    loadEmployees(); // recarrega a tabela
                    swal("Sucesso!", "Funcionário atualizado com sucesso.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao atualizar funcionário:", err));
    });





    // Confirmar delete
    $('#confirmDeleteEmployee').on('click', function() {
        const employeeId = Number($('#delete-employeeid').val()); // garante que é número

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
                    loadEmployees(); // recarrega a tabela
                    swal("Deletado!", "Employee excluído.", "success");
                } else {
                    swal("Erro!", data.message, "error");
                }
            })
            .catch(err => console.error("Erro ao deletar Employee:", err));
    });
})
</script>


<!-- Nosso componente -->