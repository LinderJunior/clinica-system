<?php 
include_once __DIR__ . '/src/components/header.php';
?>



<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">

                    <div class="d-inline">
                        <h5>TITULO DA ENTIDADE 1</h5>

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
                                <div class="card-header">
                                    <h5>TITULO DA TABELA/FORMULARIO</h5>
                                    <span>Add class of <code>.form-control</code> with
                                        <code>&lt;input&gt;</code> tag</span>
                                </div>
                                <div class="card-block">

                                    <!-- LINDERCHECK: CONTEUDO AQUI, SEJA TABELA,CARD, LISTA OU QUALQUER COISA  -->







                                    <!-- Filtros do Relatório -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="filterStartDate">Data Início</label>
                                            <input type="date" id="filterStartDate" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="filterEndDate">Data Fim</label>
                                            <input type="date" id="filterEndDate" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="filterDoctor">Médico</label>
                                            <select id="filterDoctor" class="form-control">
                                                <option value="">Todos</option>
                                                <option value="1">Dr. Pedro</option>
                                                <option value="2">Dra. Ana</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end">
                                            <button id="btnFilterReport" class="btn btn-primary w-100">
                                                <i class="feather icon-search"></i> Filtrar
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Cards de Resumo -->
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <div class="card bg-info text-white">
                                                <div class="card-body">
                                                    <h6>Total Pacientes</h6>
                                                    <h3 id="totalPatients">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-success text-white">
                                                <div class="card-body">
                                                    <h6>Total Consultas</h6>
                                                    <h3 id="totalAppointments">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-warning text-white">
                                                <div class="card-body">
                                                    <h6>Total Faturamento</h6>
                                                    <h3 id="totalRevenue">0 MZN</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabela do Relatório -->
                                    <div class="table-responsive">
                                        <table id="reportTable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Paciente</th>
                                                    <th>Médico</th>
                                                    <th>Especialidade</th>
                                                    <th>Data Consulta</th>
                                                    <th>Valor</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Será preenchido dinamicamente -->
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Botões de Exportação -->
                                    <div class="mt-3">
                                        <button id="exportExcel" class="btn btn-success">
                                            <i class="feather icon-file"></i> Exportar Excel
                                        </button>
                                        <button id="exportPDF" class="btn btn-danger">
                                            <i class="feather icon-file-text"></i> Exportar PDF
                                        </button>
                                    </div>

                                    <!-- Scripts -->
                                    <script>
                                    $(document).ready(function() {
                                        const table = $('#reportTable').DataTable({
                                            responsive: true,
                                            pageLength: 10,
                                            autoWidth: false,
                                            dom: 'Bfrtip',
                                            buttons: ['excel', 'pdf', 'print']
                                        });

                                        function loadReport(filters = {}) {
                                            // Aqui você pode fazer fetch no backend enviando filtros
                                            // Exemplo estático para teste
                                            const sampleData = [{
                                                    id: 1,
                                                    patient: "Ana Marques",
                                                    doctor: "Dr. Pedro",
                                                    specialty: "Cardiologia",
                                                    date: "2025-09-26",
                                                    value: 2000,
                                                    status: "Concluída"
                                                },
                                                {
                                                    id: 2,
                                                    patient: "Linder Junior",
                                                    doctor: "Dra. Ana",
                                                    specialty: "Pediatria",
                                                    date: "2025-09-25",
                                                    value: 1500,
                                                    status: "Agendada"
                                                }
                                            ];

                                            table.clear();
                                            sampleData.forEach(row => {
                                                table.row.add([
                                                    row.id,
                                                    row.patient,
                                                    row.doctor,
                                                    row.specialty,
                                                    row.date,
                                                    row.value,
                                                    row.status
                                                ]);
                                            });
                                            table.draw();

                                            // Atualiza cards
                                            $('#totalPatients').text(sampleData.length);
                                            $('#totalAppointments').text(sampleData.length);
                                            $('#totalRevenue').text(sampleData.reduce((sum, r) => sum + r.value,
                                                0) + " MZN");
                                        }

                                        loadReport();

                                        $('#btnFilterReport').on('click', function() {
                                            const filters = {
                                                startDate: $('#filterStartDate').val(),
                                                endDate: $('#filterEndDate').val(),
                                                doctorId: $('#filterDoctor').val()
                                            };
                                            loadReport(filters);
                                        });

                                        // Export buttons
                                        $('#exportExcel').on('click', function() {
                                            table.button('.buttons-excel').trigger();
                                        });
                                        $('#exportPDF').on('click', function() {
                                            table.button('.buttons-pdf').trigger();
                                        });
                                    });
                                    </script>









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