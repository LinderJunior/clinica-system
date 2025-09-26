<?php 

include_once __DIR__ . './../../src/components/header.php';

?>

<div class="pcoded-content">

    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h5 class="mb-0">Gestão de Funcionarios</h5>
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
                                    <h5>Tabela de Funcionario</h5>
                                    <span>Gestão centralizada dos funcionarios</span>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table id="userTable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">ID</th>
                                                    <th>Nome</th>
                                                    <th>B.I</th>
                                                    <th>Numero de telefone</th>
                                                    <th>Posicoes</th>
                                                    <th style="width: 180px; text-align:center;">Ações</th>
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


    let employeesData = []; // variável global acessível no .on('click')



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
    function loadEmployees() {
        fetch("routes/employeeRoutes.php")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    employeesData = data.data; // <-- aqui guardamos os funcionários


                    table.clear();
                    data.data.forEach(employee => table.row.add([
                        employee.id,
                        employee.name,
                        employee.bi,
                        employee.phoneNumber,
                        employee.positions.map(p => p.type).join(", "), // só nomes para exibir
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