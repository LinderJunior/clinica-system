<?php
// Página de listagem de médicos
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Lista de Médicos</h5>
                <div class="card-header-right">
                    <a href="link.php?route=6" class="btn btn-primary btn-sm">
                        <i class="feather icon-plus"></i> Novo Médico
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Especialidade</th>
                                <th>CRM</th>
                                <th>Telefone</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Dr. Carlos Mendes</td>
                                <td>Cardiologia</td>
                                <td>CRM-SP 12345</td>
                                <td>(11) 98888-7777</td>
                                <td>
                                    <a href="link.php?route=8&id=1" class="btn btn-info btn-sm">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                    <a href="link.php?route=9&id=1" class="btn btn-danger btn-sm">
                                        <i class="feather icon-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Dra. Ana Paula Santos</td>
                                <td>Dermatologia</td>
                                <td>CRM-SP 54321</td>
                                <td>(11) 97777-8888</td>
                                <td>
                                    <a href="link.php?route=8&id=2" class="btn btn-info btn-sm">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                    <a href="link.php?route=9&id=2" class="btn btn-danger btn-sm">
                                        <i class="feather icon-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
