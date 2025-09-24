<?php
/**
 * Arquivo central para gerenciamento de rotas
 * Este arquivo serve como um ponto de entrada para todas as rotas da aplicação
 */

// Definir constante para o diretório raiz do projeto
define('ROOT_DIR', dirname(__DIR__));

// Função para incluir rotas específicas com base no parâmetro da URL
function routeRequest() {
    // Verificar se existe um parâmetro de rota
    $route = $_GET['route'] ?? '';
    
    // Roteamento baseado no parâmetro
    switch ($route) {
        case 'auth':
            require_once __DIR__ . '/authRoutes.php';
            break;
        case 'users':
            require_once __DIR__ . '/userRoutes.php';
            break;
        case 'patients':
            require_once __DIR__ . '/patientRoutes.php';
            break;
        case 'positions':
            require_once __DIR__ . '/positionRoutes.php';
            break;
        case 'employees':
            require_once __DIR__ . '/employeeRoutes.php';
            break;
        case 'roles':
            require_once __DIR__ . '/roleRoutes.php';
            break;
        case 'medications':
            require_once __DIR__ . '/medicationRoutes.php';
            break;
        case 'consults':
            require_once __DIR__ . '/consultRoutes.php';
            break;
        case 'diagnoses':
            require_once __DIR__ . '/diagnosisRoutes.php';
            break;
        case 'recipes':
            require_once __DIR__ . '/recipeRoutes.php';
            break;
        // Adicione mais casos conforme necessário para outras rotas
        // case 'appointments':
        //     require_once __DIR__ . '/appointmentRoutes.php';
        //     break;
        default:
            // Rota não encontrada
            header("Content-Type: application/json");
            echo json_encode([
                "status" => "error",
                "message" => "Rota não encontrada"
            ]);
            exit;
    }
}

// Executar o roteamento
routeRequest();
