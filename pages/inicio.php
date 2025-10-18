<?php 

include_once __DIR__ . '/../src/components/header.php';
?>

<div class="pcoded-content">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">

                    <div class="d-inline">
                        <h7>Bem-vindo ao Sistema de Gestão da Clínica Linder</h7>

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
                                    <h5>Selecione uma opção no menu lateral para começar.</h5>
                                </div>

                                <div class="card-block">

                                    <!-- LINDERCHECK: CONTEUDO AQUI, SEJA TABELA,CARD, LISTA OU QUALQUER COISA  -->

                                    <div class="card-body">


                                        <div class="row mt-4">
                                            <div class="col-md-3 mb-4">
                                                <a href="link.php?route=3" class="text-decoration-none">
                                                    <div class="card bg-primary text-white h-100"
                                                        style="cursor: pointer; transition: transform 0.3s;"
                                                        onmouseover="this.style.transform='scale(1.05)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <i class="feather icon-users f-30 mr-3"></i>
                                                                <h5 class="card-title mb-0">Pacientes</h5>
                                                            </div>
                                                            <p class="card-text">Gerenciar cadastro de pacientes</p>
                                                            <div class="text-right mt-3">
                                                                <i class="feather icon-chevron-right"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="col-md-3 mb-4">
                                                <a href="link.php?route=19" class="text-decoration-none">
                                                    <div class="card bg-success text-white h-100"
                                                        style="cursor: pointer; transition: transform 0.3s;"
                                                        onmouseover="this.style.transform='scale(1.05)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <i class="feather icon-user f-30 mr-3"></i>
                                                                <h5 class="card-title mb-0">Médicos</h5>
                                                            </div>
                                                            <p class="card-text">Gerenciar cadastro de médicos</p>
                                                            <div class="text-right mt-3">
                                                                <i class="feather icon-chevron-right"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="col-md-3 mb-4">
                                                <a href="link.php?route=3" class="text-decoration-none">
                                                    <div class="card bg-info text-white h-100"
                                                        style="cursor: pointer; transition: transform 0.3s;"
                                                        onmouseover="this.style.transform='scale(1.05)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <i class="feather icon-calendar f-30 mr-3"></i>
                                                                <h5 class="card-title mb-0">Consultas</h5>
                                                            </div>
                                                            <p class="card-text">Gerenciar agendamento de consultas</p>
                                                            <div class="text-right mt-3">
                                                                <i class="feather icon-chevron-right"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="col-md-3 mb-4">
                                                <a href="link.php?route=3" class="text-decoration-none">
                                                    <div class="card bg-warning text-white h-100"
                                                        style="cursor: pointer; transition: transform 0.3s;"
                                                        onmouseover="this.style.transform='scale(1.05)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <i class="feather icon-clipboard f-30 mr-3"></i>
                                                                <h5 class="card-title mb-0">Exames</h5>
                                                            </div>
                                                            <p class="card-text">Gerenciar cadastro de exames</p>
                                                            <div class="text-right mt-3">
                                                                <i class="feather icon-chevron-right"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-3 mb-4">
                                                <a href="link.php?route=3" class="text-decoration-none">
                                                    <div class="card bg-danger text-white h-100"
                                                        style="cursor: pointer; transition: transform 0.3s;"
                                                        onmouseover="this.style.transform='scale(1.05)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <i class="feather icon-pie-chart f-30 mr-3"></i>
                                                                <h5 class="card-title mb-0">Relatórios</h5>
                                                            </div>
                                                            <p class="card-text">Visualizar relatórios do sistema</p>
                                                            <div class="text-right mt-3">
                                                                <i class="feather icon-chevron-right"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="col-md-3 mb-4">
                                                <a href="link.php?route=3" class="text-decoration-none">
                                                    <div class="card bg-dark text-white h-100"
                                                        style="cursor: pointer; transition: transform 0.3s;"
                                                        onmouseover="this.style.transform='scale(1.05)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <i class="feather icon-settings f-30 mr-3"></i>
                                                                <h5 class="card-title mb-0">Configurações</h5>
                                                            </div>
                                                            <p class="card-text">Gerenciar configurações do sistema</p>
                                                            <div class="text-right mt-3">
                                                                <i class="feather icon-chevron-right"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>


                                    </div>
                                    <!--Fim card block onde tem os dashboards -->
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