<?php
// link.php
?>
<div class="page-body">
    <?php
    // Pega a rota da URL
    $link = isset($_GET["route"]) ? $_GET["route"] : "";
    // Definição das páginas disponíveis
    $pag = [];
    // Página inicial (dashboard)
    $pag[1] = "inicio.php"; 

    // Pacientes
    $pag[2] = "patients/patient-register.php";
    $pag[3] = "patients/patient-list.php";
  
    // Médicos
    $pag[4] = "medicos/cadastro.php";
    $pag[5] = "medicos/lista.php";
  
    // Consultas
    $pag[6] = "consult/consult-register.php";
    $pag[7] = "consult/consult-list.php";

    //Diagnosticos 
    $pag[8] = "diagnoses/diagnose-register.php";
    $pag[9]= "diagnoses/diagnose-list.php";
   
    // Receitas
    $pag[10] = "recipes/recipe-register.php";
    $pag[11] = "recipes/recipe-list.php";
 

    // Usuários
    //$pag[11] = "users/user-register.php";
    $pag[12] = "users/user-list.php";


    // Funcionario
    $pag[13] = "employees/employee-register.php";
    $pag[14] = "employees/employee-list.php";

    // Medicamentos
    $pag[15] = "medications/medication-register.php";
    $pag[16] = "medications/medication-list.php";
    $pag[25] = "medications/medication-stock-entry.php";
    $pag[26] = "medications/medication-stock-report.php";

    // Pesos dos Clientes
    $pag[22] = "client-weights/client-weight-register.php";
    $pag[23] = "client-weights/client-weight-list.php";
    $pag[24] = "client-weights/client-weight-progress.php";

    // Relatórios
    $pag[17] = "consult/consult-details.php";
    $pag[18] = "relatorios/consultas.php";
    $pag[19] = "relatorios/financeiro.php";

    // Configurações
    $pag[20] = "configuracoes/sistema.php";
    $pag[21] = "configuracoes/perfil.php";

    // Página de erro
    $pag[404] = "error.php";

    // Carregamento da página solicitada
    if (!empty($link)) {
        if (isset($pag[$link]) && file_exists("pages/" . $pag[$link])) {
            include "pages/" . $pag[$link];
        } else {
            include "pages/" . $pag[404];
        }
    } else {
        // Carrega a página inicial (dashboard)
        include "pages/" . $pag[1];
    }
    ?>
</div>