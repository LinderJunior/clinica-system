<?php
// Configuração de erro
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Headers para API
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Tratar requisições OPTIONS (CORS preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/controllers/StockMovementController.php';

try {
    // Instanciar controlador
    $controller = new StockMovementController($pdo);
    
    // Obter ação da URL
    $action = $_GET['action'] ?? 'list';
    
    // Roteamento das ações
    switch ($action) {
        case 'create':
            $response = $controller->createStockMovement();
            break;
            
        case 'list':
        case 'get':
            $response = $controller->getStockMovements();
            break;
            
        case 'update':
            $response = $controller->updateStockMovement();
            break;
            
        case 'delete':
            $response = $controller->deleteStockMovement();
            break;
            
        case 'stock':
            $response = $controller->getCurrentStock();
            break;
            
        case 'report':
            $response = $controller->getStockReport();
            break;
            
        default:
            $response = [
                'status' => 'error',
                'message' => 'Ação não reconhecida. Ações disponíveis: create, list, get, update, delete, stock, report'
            ];
            break;
    }
    
    // Definir código de resposta HTTP
    if ($response['status'] === 'success') {
        http_response_code(200);
    } else {
        http_response_code(400);
    }
    
    // Retornar resposta JSON
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro interno do servidor: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
