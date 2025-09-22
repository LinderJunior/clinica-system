<?php

// Configuração de erro e cabeçalho JSON
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/PositionService.php';

// Instância do controlador de posições/cargos
$positionController = new PositionController($pdo);

// Método HTTP da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Função para obter os dados do corpo da requisição
function getRequestData() {
    return json_decode(file_get_contents("php://input"), true) ?? [];
}

// Manipulação da requisição
switch ($method) {
    case 'POST':
        handlePostRequest($positionController);
        break;
    case 'GET':
        handleGetRequest($positionController);
        break;
    default:
        sendResponse(["status" => "error", "message" => "Método HTTP não suportado!"]);
}

/**
 * Processa requisições POST
 */
function handlePostRequest($positionController) {
    $data = getRequestData();

    if (!isset($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'add' => $positionController->addPosition(
            $data['type'], 
            $data['description']
        ),
        'update' => $positionController->editPosition(
            $data['id'],
            $data['type'], 
            $data['description']
        ),
        'delete' => $positionController->removePosition($data['id']),
        'search' => $positionController->searchPositionsByType($data['type']),
        default => ["status" => "error", "message" => "Ação inválida!"]
    };

    sendResponse($response);
}

/**
 * Processa requisições GET
 */
function handleGetRequest($positionController) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);
        $response = $positionController->getPositionById($id);
    } elseif (isset($_GET['search']) && !empty($_GET['search'])) {
        $type = htmlspecialchars($_GET['search']);
        $response = $positionController->searchPositionsByType($type);
    } else {
        $response = $positionController->listPositions();
    }
    sendResponse($response);
}

/**
 * Envia a resposta como JSON
 */
function sendResponse($response) {
    echo json_encode($response);
    exit;
}
?>
