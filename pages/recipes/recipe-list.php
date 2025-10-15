<?php 
include_once __DIR__ . './../../src/components/header.php';
?>

<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h5 class="mb-0">
                        Gestão de Receitas Médicas
                    </h5>
                    <button class="btn btn-mat waves-effect waves-light btn-success" id="btnAddRecipe">
                        Nova Receita
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
                                    <h5>Tabela de Receitas</h5>
                                    <span>Gestão centralizada de receitas médicas</span>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table id="recipeTable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Data</th>
                                                    <th>Hora</th>
                                                    <th>Paciente</th>
                                                    <th>Médico</th>
                                                    <th>Qtd. Medicamentos</th>
                                                    <th>Total (MZN)</th>
                                                    <th style="width: 160px; text-align:center;">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php include_once __DIR__ . '/recipe-modal.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector"></div>
    </div>
</div>

<style>
#recipeTable th:last-child,
#recipeTable td:last-child {
    width: 160px;
    text-align: center;
    white-space: nowrap;
}

#recipeTable .btn-sm {
    padding: 2px 6px;
    font-size: 0.85rem;
}
</style>

<script>
$(document).ready(function() {
    const table = $('#recipeTable').DataTable({
        responsive: true,
        autoWidth: false,
        paging: true,
        pageLength: 10,
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
            zeroRecords: "Nenhuma receita encontrada",
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

    // Função para carregar receitas
    function loadRecipes() {
        fetch("routes/index.php?route=recipes")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && Array.isArray(data.data)) {
                    table.clear();
                    data.data.forEach(recipe => {
                        table.row.add([
                            recipe.id,
                            recipe.consult_date ?? '-',
                            recipe.consult_time ?? '-',
                            recipe.patient_name ?? '—',
                            recipe.doctor_name ?? '—',
                            recipe.medications_count ?? 0,
                            recipe.total_price ?? '0.00',
                            null
                        ]);
                    });
                    table.draw();
                } else {
                    console.error("Erro ao carregar receitas:", data.message);
                }
            })
            .catch(err => console.error("Erro:", err));
    }
    loadRecipes();

    // Função genérica de ação
    $('#recipeTable tbody').on('click', '.action', function() {
        const action = $(this).data('action');
        const data = table.row($(this).parents('tr')).data();

        if (action === "view") {
            $('#modalViewRecipe').modal('show');
        } else if (action === "edit") {
            $('#modalEditRecipe').modal('show');
        } else if (action === "delete") {
            $('#modalDeleteRecipe').modal('show');
        }
    });



});
</script>