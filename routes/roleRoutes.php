<?php

// Configuração de erro e cabeçalho JSON
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/RoleService.php';

// Instância do controlador de funções/papéis
$roleController = new RoleController($pdo);

// Método HTTP da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Função para obter os dados do corpo da requisição
function getRequestData() {
    return json_decode(file_get_contents("php://input"), true) ?? [];
}

// Manipulação da requisição
switch ($method) {
    case 'POST':
        handlePostRequest($roleController);
        break;
    case 'GET':
        handleGetRequest($roleController);
        break;
    default:
        sendResponse(["status" => "error", "message" => "Método HTTP não suportado!"]);
}

/**
 * Processa requisições POST
 */
function handlePostRequest($roleController) {
    $data = getRequestData();

    if (!isset($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'add' => $roleController->addRole($data['role']),
        'update' => $roleController->editRole($data['id'], $data['role']),
        'delete' => $roleController->removeRole($data['id']),
        'search' => $roleController->searchRolesByName($data['role']),
        default => ["status" => "error", "message" => "Ação inválida!"]
    };

    sendResponse($response);
}

/**
 * Processa requisições GET
 */
function handleGetRequest($roleController) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);
        $response = $roleController->getRoleById($id);
    } elseif (isset($_GET['search']) && !empty($_GET['search'])) {
        $role = htmlspecialchars($_GET['search']);
        $response = $roleController->searchRolesByName($role);
    } else {
        $response = $roleController->listRoles();
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
