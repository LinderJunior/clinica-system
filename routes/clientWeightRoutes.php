<?php

// Configuração de erro e cabeçalho JSON
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/ClientWeightService.php';

// Instância do controlador de pesos dos clientes
$clientWeightController = new ClientWeightController($pdo);

// Método HTTP da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Função para obter os dados do corpo da requisição
function getRequestData() {
    return json_decode(file_get_contents("php://input"), true) ?? [];
}

// Manipulação da requisição
switch ($method) {
    case 'POST':
        handlePostRequest($clientWeightController);
        break;
    case 'GET':
        handleGetRequest($clientWeightController);
        break;
    case 'PUT':
        handlePutRequest($clientWeightController);
        break;
    case 'DELETE':
        handleDeleteRequest($clientWeightController);
        break;
    default:
        sendResponse(["status" => "error", "message" => "Método HTTP não suportado!"]);
}

/**
 * Processa requisições POST
 */
function handlePostRequest($clientWeightController) {
    $data = getRequestData();

    if (!isset($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'add' => $clientWeightController->addClientWeight(
            $data['client_id'], 
            $data['height'], 
            $data['weight'], 
            $data['bmi'] ?? null, 
            $data['classification'] ?? null
        ),
        'search_by_client' => $clientWeightController->getClientWeightsByClientId($data['client_id']),
        'search_by_date_range' => $clientWeightController->getClientWeightsByDateRange(
            $data['start_date'], 
            $data['end_date'], 
            $data['client_id'] ?? null
        ),
        default => ["status" => "error", "message" => "Ação inválida!"]
    };

    sendResponse($response);
}

/**
 * Processa requisições GET
 */
function handleGetRequest($clientWeightController) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);
        $response = $clientWeightController->getClientWeightById($id);
    } elseif (isset($_GET['client_id']) && is_numeric($_GET['client_id'])) {
        $clientId = intval($_GET['client_id']);
        $response = $clientWeightController->getClientWeightsByClientId($clientId);
    } elseif (isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $startDate = htmlspecialchars($_GET['start_date']);
        $endDate = htmlspecialchars($_GET['end_date']);
        $clientId = isset($_GET['client_id']) && is_numeric($_GET['client_id']) ? intval($_GET['client_id']) : null;
        $response = $clientWeightController->getClientWeightsByDateRange($startDate, $endDate, $clientId);
    } else {
        $response = $clientWeightController->listClientWeights();
    }
    sendResponse($response);
}

/**
 * Processa requisições PUT (atualização)
 */
function handlePutRequest($clientWeightController) {
    $data = getRequestData();

    if (!isset($data['id']) || !is_numeric($data['id'])) {
        sendResponse(["status" => "error", "message" => "ID do registro é obrigatório para atualização!"]);
        return;
    }

    if (!isset($data['client_id']) || !isset($data['height']) || !isset($data['weight'])) {
        sendResponse(["status" => "error", "message" => "Dados obrigatórios não fornecidos!"]);
        return;
    }

    $response = $clientWeightController->editClientWeight(
        intval($data['id']),
        intval($data['client_id']), 
        floatval($data['height']), 
        floatval($data['weight']), 
        isset($data['bmi']) ? floatval($data['bmi']) : null, 
        $data['classification'] ?? null
    );

    sendResponse($response);
}

/**
 * Processa requisições DELETE
 */
function handleDeleteRequest($clientWeightController) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);
        $response = $clientWeightController->removeClientWeight($id);
    } else {
        $response = ["status" => "error", "message" => "ID do registro é obrigatório para exclusão!"];
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
