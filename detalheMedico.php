<?php 
include_once __DIR__ . '/src/components/header.php';
?>

<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">

                    <div class="d-inline">
                        <h5>Detalhes de Médico</h5>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Form Components</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Basic Form Inputs</a>
                        </li>
                    </ul>
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
                                <!-- <div class="card-header">
                                    <h5>TITULO DA TABELA/FORMULARIO</h5>
                                    <span>Add class of <code>.form-control</code> with
                                        <code>&lt;input&gt;</code> tag</span>
                                </div> -->
                                <div class="card-block">

                                    <!-- LINDERCHECK: CONTEUDO AQUI, SEJA TABELA,CARD, LISTA OU QUALQUER COISA  -->


                                    <div class="row">

                                        <!-- Coluna esquerda: Perfil e Estatísticas -->
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <!-- <img src="https://via.placeholder.com/150"
                                                        class="img-fluid rounded-circle mb-3" alt="Foto Médico"> -->
                                                    <h4 class="mb-1">Dr. Pedro Nunes</h4>
                                                    <p class="text-muted">CRM: 12345</p>
                                                    <p class="text-muted">Especialidade: Neuro</p>
                                                </div>
                                            </div>

                                            <div class="card mt-3">
                                                <div class="card-header">
                                                    <h6>Estatísticas</h6>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            Número de Consultas
                                                            <span class="badge badge-primary">5</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            Número de Pacientes Atendidos
                                                            <span class="badge badge-success">12</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            Consultas Agendadas
                                                            <span class="badge badge-warning">3</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            Consultas Canceladas
                                                            <span class="badge badge-danger">1</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            Faturamento Gerado
                                                            <span class="badge badge-info">20.000 MZN</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Coluna direita: Relatório de Pacientes -->
                                        <div class="col-md-8">
                                            <div class="card">
                                                <div
                                                    class="card-header d-flex justify-content-between align-items-center">
                                                    <h6>Relatório de Consultas</h6>
                                                    <div class="d-flex">
                                                        <input type="date" id="filterStart"
                                                            class="form-control form-control-sm mr-2"
                                                            placeholder="Data Início">
                                                        <input type="date" id="filterEnd"
                                                            class="form-control form-control-sm mr-2"
                                                            placeholder="Data Fim">
                                                        <select id="filterType"
                                                            class="form-control form-control-sm mr-2">
                                                            <option value="">Todos os Tipos</option>
                                                            <option value="Consulta Geral">Consulta Geral</option>
                                                            <option value="Retorno">Retorno</option>
                                                            <option value="Exame">Exame</option>
                                                        </select>
                                                        <button class="btn btn-sm btn-primary"
                                                            id="btnFilter">Filtrar</button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table id="patientTable"
                                                        class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Data</th>
                                                                <th>Paciente</th>
                                                                <th>Horário</th>
                                                                <th>Tipo de Consulta</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>2025-09-26</td>
                                                                <td>Ana Marques</td>
                                                                <td>09:00</td>
                                                                <td>Consulta Geral</td>
                                                                <td><span class="badge badge-success">Confirmada</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2025-09-26</td>
                                                                <td>Linder Junior</td>
                                                                <td>11:00</td>
                                                                <td>Retorno</td>
                                                                <td><span class="badge badge-warning">Agendada</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2025-09-27</td>
                                                                <td>Maria Silva</td>
                                                                <td>10:00</td>
                                                                <td>Exame</td>
                                                                <td><span class="badge badge-danger">Cancelada</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Scripts DataTable + Buttons -->
                                    <link rel="stylesheet"
                                        href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
                                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js">
                                    </script>
                                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js">
                                    </script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js">
                                    </script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js">
                                    </script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js">
                                    </script>
                                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js">
                                    </script>
                                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js">
                                    </script>

                                    <script>
                                    $(document).ready(function() {

                                        // Inicializa DataTable com botões de exportação
                                        const patientTable = $('#patientTable').DataTable({
                                            responsive: true,
                                            autoWidth: false,
                                            pageLength: 10,
                                            lengthMenu: [10, 25, 50, 100],
                                            order: [
                                                [0, 'asc']
                                            ],
                                            columnDefs: [{
                                                    targets: 4,
                                                    orderable: false
                                                } // Status não ordenável
                                            ],
                                            language: {
                                                search: "Pesquisar:",
                                                lengthMenu: "Mostrar _MENU_ registros por página",
                                                zeroRecords: "Nenhum paciente encontrado",
                                                info: "Mostrando _START_ a _END_ de _TOTAL_ pacientes",
                                                infoEmpty: "Nenhum dado disponível",
                                                infoFiltered: "(filtrado de _MAX_ registros no total)",
                                                paginate: {
                                                    first: "Primeiro",
                                                    last: "Último",
                                                    next: "Próximo",
                                                    previous: "Anterior"
                                                }
                                            },
                                            dom: 'Bfrtip',
                                            buttons: [{
                                                    extend: 'excelHtml5',
                                                    text: '<i class="fas fa-file-excel"></i> Excel',
                                                    titleAttr: 'Exportar para Excel',
                                                    className: 'btn btn-success btn-sm',
                                                    title: 'Relatorio_Pacientes',
                                                    exportOptions: {
                                                        columns: ':visible'
                                                    }
                                                },
                                                {
                                                    extend: 'pdfHtml5',
                                                    text: '<i class="fas fa-file-pdf"></i> PDF',
                                                    titleAttr: 'Exportar para PDF',
                                                    className: 'btn btn-danger btn-sm',
                                                    orientation: 'landscape',
                                                    pageSize: 'A4',
                                                    title: 'Relatorio_Pacientes',
                                                    exportOptions: {
                                                        columns: ':visible'
                                                    }
                                                }
                                            ]

                                        });

                                        // Filtro personalizado
                                        $('#btnFilter').on('click', function() {
                                            const start = $('#filterStart').val();
                                            const end = $('#filterEnd').val();
                                            const type = $('#filterType').val();

                                            patientTable.rows().every(function() {
                                                const rowData = this.data();
                                                const rowDate = rowData[0]; // coluna data
                                                const rowType = rowData[3]; // tipo de consulta
                                                let show = true;

                                                if (start && rowDate < start) show = false;
                                                if (end && rowDate > end) show = false;
                                                if (type && rowType !== type) show = false;

                                                if (show) {
                                                    $(this.node()).show();
                                                } else {
                                                    $(this.node()).hide();
                                                }
                                            });
                                        });
                                    });
                                    </script>

                                    <!-- FIM LINDERCHECK: CONTEUDO AQUI, SEJA TABELA,CARD, LISTA OU QUALQUER COISA  -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div id="styleSelector">
        </div>
    </div>
</div>