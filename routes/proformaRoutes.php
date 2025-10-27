<?php

// Configuração de erro e cabeçalho JSON
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/ProformaService.php';

// Instância do controlador de proformas
$proformaController = new ProformaController($pdo);

// Método HTTP da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Função para obter os dados do corpo da requisição
function getRequestData() {
    return json_decode(file_get_contents("php://input"), true) ?? [];
}

// Manipulação da requisição
switch ($method) {
    case 'POST':
        handlePostRequest($proformaController);
        break;
    case 'GET':
        handleGetRequest($proformaController);
        break;
    case 'PUT':
        handlePutRequest($proformaController);
        break;
    case 'DELETE':
        handleDeleteRequest($proformaController);
        break;
    default:
        sendResponse(["status" => "error", "message" => "Método HTTP não suportado!"]);
}

/**
 * Processa requisições POST
 */
function handlePostRequest($proformaController) {
    $data = getRequestData();

    if (!isset($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'add' => $proformaController->addProformaInvoice(
            $data['client_name'],
            $data['issue_date'],
            $data['due_date'],
            $data['currency'] ?? 'MZN',
            $data['status'] ?? 'PENDING',
            $data['notes'] ?? null,
            $data['items'] ?? []
        ),
        'search' => $proformaController->searchProformasByClient($data['client_name']),
        'search_by_status' => $proformaController->getProformasByStatus($data['status']),
        'add_item' => $proformaController->addItemToProforma(
            $data['proforma_id'],
            $data['description'],
            $data['quantity'],
            $data['unit_price']
        ),
        'search_items' => $proformaController->searchItemsByDescription($data['description']),
        'recalculate' => $proformaController->recalculateProformaTotals($data['id']),
        'next_invoice_number' => $proformaController->getNextInvoiceNumber(),
        default => ["status" => "error", "message" => "Ação inválida!"]
    };

    sendResponse($response);
}

/**
 * Processa requisições GET
 */
function handleGetRequest($proformaController) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        // Buscar proforma específica por ID
        $id = intval($_GET['id']);
        $response = $proformaController->getProformaInvoiceById($id);
    } elseif (isset($_GET['search']) && !empty($_GET['search'])) {
        // Buscar proformas por nome do cliente
        $clientName = htmlspecialchars($_GET['search']);
        $response = $proformaController->searchProformasByClient($clientName);
    } elseif (isset($_GET['status']) && !empty($_GET['status'])) {
        // Buscar proformas por status
        $status = htmlspecialchars($_GET['status']);
        $response = $proformaController->getProformasByStatus($status);
    } elseif (isset($_GET['action']) && $_GET['action'] === 'next_invoice_number') {
        // Obter próximo número de invoice
        $response = $proformaController->getNextInvoiceNumber();
    } else {
        // Listar todas as proformas
        $response = $proformaController->listProformaInvoices();
    }
    
    sendResponse($response);
}

/**
 * Processa requisições PUT
 */
function handlePutRequest($proformaController) {
    $data = getRequestData();

    if (!isset($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'update' => $proformaController->editProformaInvoice(
            $data['id'],
            $data['invoice_number'],
            $data['client_name'],
            $data['issue_date'],
            $data['due_date'],
            $data['currency'] ?? 'MZN',
            $data['status'] ?? 'PENDING',
            $data['notes'] ?? null,
            $data['items'] ?? []
        ),
        'update_status' => $proformaController->updateProformaStatus(
            $data['id'],
            $data['status']
        ),
        'update_item' => $proformaController->updateProformaItem(
            $data['item_id'],
            $data['description'],
            $data['quantity'],
            $data['unit_price']
        ),
        default => ["status" => "error", "message" => "Ação inválida!"]
    };

    sendResponse($response);
}

/**
 * Processa requisições DELETE
 */
function handleDeleteRequest($proformaController) {
    $data = getRequestData();

    if (!isset($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'delete' => $proformaController->removeProformaInvoice($data['id']),
        'delete_item' => $proformaController->removeProformaItem($data['item_id']),
        default => ["status" => "error", "message" => "Ação inválida!"]
    };

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
