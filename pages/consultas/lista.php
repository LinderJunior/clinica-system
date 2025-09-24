<?php
// Página de listagem de consultas
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Lista de Consultas</h5>
                <div class="card-header-right">
                    <a href="link.php?route=10" class="btn btn-primary btn-sm">
                        <i class="feather icon-plus"></i> Nova Consulta
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Paciente</th>
                                <th>Médico</th>
                                <th>Data</th>
                                <th>Hora</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>João Silva</td>
                                <td>Dr. Carlos Mendes</td>
                                <td>25/09/2025</td>
                                <td>14:30</td>
                                <td><span class="badge badge-success">Confirmada</span></td>
                                <td>
                                    <a href="link.php?route=12&id=1" class="btn btn-info btn-sm">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                    <a href="link.php?route=13&id=1" class="btn btn-danger btn-sm">
                                        <i class="feather icon-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Maria Oliveira</td>
                                <td>Dra. Ana Paula Santos</td>
                                <td>26/09/2025</td>
                                <td>10:15</td>
                                <td><span class="badge badge-warning">Pendente</span></td>
                                <td>
                                    <a href="link.php?route=12&id=2" class="btn btn-info btn-sm">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                    <a href="link.php?route=13&id=2" class="btn btn-danger btn-sm">
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
