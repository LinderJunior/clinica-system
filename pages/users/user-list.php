<?php
include_once __DIR__ . './../../src/components/header.php';
?>

<div class="pcoded-content">

    <div class="page-header card py-2 px-3">
        <div class="row align-items-center">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-secondary" style="font-size: 1.25rem; font-weight: 500;">
                    Gestão de Usuários
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
                                <h6 class="text-secondary mb-0 text-uppercase">Tabela de Usuários</h6>
                                <small class="text-muted">Gestão centralizada de usuários</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="userTable" class="table table-custom table-striped table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Employee ID</th>
                                            <th>Role</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php include_once __DIR__ . '/user-modal.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inclui o CSS e JS genérico -->
<link rel="stylesheet" href="table-style.css">
<script src="./table-init.js"></script>



<script>
$(document).ready(function() {
    // Inicializa DataTable genérico para usuários
    initDataTable('#userTable', 'routes/userRoutes.php', 'Relatório de Usuários');

    // Botão adicionar usuário
    $('#btnAddUser').on('click', function() {
        $('#userModal').modal('show');
    });
});
</script>