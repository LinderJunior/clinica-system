<?php

// Configuração de erro e cabeçalho JSON
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/PatientService.php';

// Instância do controlador de pacientes
$patientController = new PatientController($pdo);

// Método HTTP da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Função para obter os dados do corpo da requisição
function getRequestData() {
    return json_decode(file_get_contents("php://input"), true) ?? [];
}

// Manipulação da requisição
switch ($method) {
    case 'POST':
        handlePostRequest($patientController);
        break;
    case 'GET':
        handleGetRequest($patientController);
        break;
    default:
        sendResponse(["status" => "error", "message" => "Método HTTP não suportado!"]);
}

/**
 * Processa requisições POST
 */
function handlePostRequest($patientController) {
    $data = getRequestData();

    if (!isset($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'add' => $patientController->addPatient(
            $data['name'], 
            $data['dateBirth'], 
            $data['bi'], 
            $data['province'], 
            $data['city'], 
            $data['neighborhood'], 
            $data['phoneNumber'], 
            $data['iswhatsapp']
        ),
        'update' => $patientController->editPatient(
            $data['id'],
            $data['name'], 
            $data['dateBirth'], 
            $data['bi'], 
            $data['province'], 
            $data['city'], 
            $data['neighborhood'], 
            $data['phoneNumber'], 
            $data['iswhatsapp']
        ),
        'delete' => $patientController->removePatient($data['id']),
        'search' => $patientController->searchPatientsByName($data['name']),
        default => ["status" => "error", "message" => "Ação inválida!"]
    };

    sendResponse($response);
}

/**
 * Processa requisições GET
 */
function handleGetRequest($patientController) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);
        $response = $patientController->getPatientById($id);
    } elseif (isset($_GET['search']) && !empty($_GET['search'])) {
        $name = htmlspecialchars($_GET['search']);
        $response = $patientController->searchPatientsByName($name);
    } else {
        $response = $patientController->listPatients();
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
