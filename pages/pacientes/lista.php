<?php
// Página de listagem de pacientes
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Lista de Pacientes</h5>
                <div class="card-header-right">
                    <a href="link.php?route=2" class="btn btn-primary btn-sm">
                        <i class="feather icon-plus"></i> Novo Paciente
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
                                <th>CPF</th>
                                <th>Data de Nascimento</th>
                                <th>Telefone</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>João Silva</td>
                                <td>123.456.789-00</td>
                                <td>10/05/1985</td>
                                <td>(11) 98765-4321</td>
                                <td>
                                    <a href="link.php?route=4&id=1" class="btn btn-info btn-sm">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                    <a href="link.php?route=5&id=1" class="btn btn-danger btn-sm">
                                        <i class="feather icon-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Maria Oliveira</td>
                                <td>987.654.321-00</td>
                                <td>15/08/1990</td>
                                <td>(11) 91234-5678</td>
                                <td>
                                    <a href="link.php?route=4&id=2" class="btn btn-info btn-sm">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                    <a href="link.php?route=5&id=2" class="btn btn-danger btn-sm">
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
