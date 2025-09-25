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
    $pag[2] = "pacientes/cadastro.php";
    $pag[3] = "pacientes/lista.php";
    $pag[4] = "pacientes/editar.php";
    $pag[5] = "pacientes/excluir.php";

    // Médicos
    $pag[6] = "medicos/cadastro.php";
    $pag[7] = "medicos/lista.php";
    $pag[8] = "medicos/editar.php";
    $pag[9] = "medicos/excluir.php";

    // Consultas
    $pag[10] = "consultas/agendar.php";
    $pag[11] = "consultas/lista.php";
    $pag[12] = "consultas/editar.php";
    $pag[13] = "consultas/excluir.php";

    // Exames
    $pag[14] = "exames/cadastro.php";
    $pag[15] = "exames/lista.php";
    $pag[16] = "exames/editar.php";
    $pag[17] = "exames/excluir.php";

    // Usuários
    $pag[18] = "users/user-register.php";
    $pag[19] = "users/user-list.php";
    // Relatórios
    $pag[22] = "relatorios/pacientes.php";
    $pag[23] = "relatorios/consultas.php";
    $pag[24] = "relatorios/financeiro.php";

    // Configurações
    $pag[25] = "configuracoes/sistema.php";
    $pag[26] = "configuracoes/perfil.php";

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