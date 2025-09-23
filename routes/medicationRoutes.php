<?php

// Configuração de erro e cabeçalho JSON
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/MedicationService.php';

// Instância do controlador de medicamentos
$medicationController = new MedicationController($pdo);

// Método HTTP da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Função para obter os dados do corpo da requisição
function getRequestData() {
    return json_decode(file_get_contents("php://input"), true) ?? [];
}

// Manipulação da requisição
switch ($method) {
    case 'POST':
        handlePostRequest($medicationController);
        break;
    case 'GET':
        handleGetRequest($medicationController);
        break;
    default:
        sendResponse(["status" => "error", "message" => "Método HTTP não suportado!"]);
}

/**
 * Processa requisições POST
 */
function handlePostRequest($medicationController) {
    $data = getRequestData();

    if (!isset($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'add' => $medicationController->addMedication(
            $data['name'], 
            $data['type'], 
            $data['dateProduction'], 
            $data['dateExpiry'], 
            $data['qty'], 
            $data['loteNumber'], 
            $data['purchasePrice'], 
            $data['salePrice'], 
            $data['registationDate'], 
            $data['description'], 
            $data['user_id']
        ),
        'update' => $medicationController->editMedication(
            $data['id'],
            $data['name'], 
            $data['type'], 
            $data['dateProduction'], 
            $data['dateExpiry'], 
            $data['qty'], 
            $data['loteNumber'], 
            $data['purchasePrice'], 
            $data['salePrice'], 
            $data['registationDate'], 
            $data['description'], 
            $data['user_id']
        ),
        'delete' => $medicationController->removeMedication($data['id']),
        'searchByName' => $medicationController->searchMedicationsByName($data['name']),
        'searchByType' => $medicationController->searchMedicationsByType($data['type']),
        'lowStock' => $medicationController->getLowStockMedications($data['limit'] ?? 10),
        'expiring' => $medicationController->getExpiringMedications($data['daysThreshold'] ?? 30),
        'users' => $medicationController->getAllUsers(),
        default => ["status" => "error", "message" => "Ação inválida!"]
    };

    sendResponse($response);
}

/**
 * Processa requisições GET
 */
function handleGetRequest($medicationController) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);
        $response = $medicationController->getMedicationById($id);
    } elseif (isset($_GET['search']) && !empty($_GET['search'])) {
        $name = htmlspecialchars($_GET['search']);
        $response = $medicationController->searchMedicationsByName($name);
    } elseif (isset($_GET['type']) && !empty($_GET['type'])) {
        $type = htmlspecialchars($_GET['type']);
        $response = $medicationController->searchMedicationsByType($type);
    } elseif (isset($_GET['lowStock']) && $_GET['lowStock'] === 'true') {
        $limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? intval($_GET['limit']) : 10;
        $response = $medicationController->getLowStockMedications($limit);
    } elseif (isset($_GET['expiring']) && $_GET['expiring'] === 'true') {
        $days = isset($_GET['days']) && is_numeric($_GET['days']) ? intval($_GET['days']) : 30;
        $response = $medicationController->getExpiringMedications($days);
    } elseif (isset($_GET['users']) && $_GET['users'] === 'true') {
        $response = $medicationController->getAllUsers();
    } else {
        $response = $medicationController->listMedications();
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
