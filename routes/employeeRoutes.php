<?php

// Configuração de erro e cabeçalho JSON
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/EmployeeService.php';

// Instância do controlador de funcionários
$employeeController = new EmployeeController($pdo);

// Método HTTP da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Função para obter os dados do corpo da requisição
function getRequestData() {
    return json_decode(file_get_contents("php://input"), true) ?? [];
}

// Manipulação da requisição
switch ($method) {
    case 'POST':
        handlePostRequest($employeeController);
        break;
    case 'GET':
        handleGetRequest($employeeController);
        break;
    default:
        sendResponse(["status" => "error", "message" => "Método HTTP não suportado!"]);
}

/**
 * Processa requisições POST
 */
function handlePostRequest($employeeController) {

    $data = getRequestData();

    if (!isset($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'add' => $employeeController->addEmployee(
            $data['name'], 
            $data['bi'], 
            $data['phoneNumber'], 
            $data['doctor'],
            $data['positionIds']
        ),
        'update' => $employeeController->editEmployee(
            $data['id'],
            $data['name'], 
            $data['bi'], 
            $data['phoneNumber'], 
            $data['positionIds']
        ),
        'delete' => $employeeController->removeEmployee($data['id']),
        'search' => $employeeController->searchEmployeesByName($data['name']),
        'positions' => $employeeController->getAllPositions(),
        default => ["status" => "error", "message" => "Ação inválida!"]
    };

    sendResponse($response);
}

/**
 * Processa requisições GET
 */
// Lida com requisições GET
function handleGetRequest($employeeController) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);
        $response = $employeeController->getEmployeeById($id);
    } elseif (isset($_GET['search']) && !empty($_GET['search'])) {
        $name = htmlspecialchars($_GET['search']);
        $response = $employeeController->searchEmployeesByName($name);
    } elseif (isset($_GET['positions']) && $_GET['positions'] === 'true') {
        $response = $employeeController->getAllPositions();
    } elseif (isset($_GET['doctors']) && $_GET['doctors'] === 'true') {
        $response = $employeeController->listDoctors(); // apenas médicos
    } else {
        $response = $employeeController->listEmployees();
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