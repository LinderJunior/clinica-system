<?php

// Configuração de erro e cabeçalho JSON
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/DiagnosisService.php';

// Instância do controlador de diagnósticos
$diagnosisController = new DiagnosisController($pdo);

// Método HTTP da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Função para obter os dados do corpo da requisição
function getRequestData() {
    return json_decode(file_get_contents("php://input"), true) ?? [];
}

// Manipulação da requisição
switch ($method) {
    case 'POST':
        handlePostRequest($diagnosisController);
        break;
    case 'GET':
        handleGetRequest($diagnosisController);
        break;
    default:
        sendResponse(["status" => "error", "message" => "Método HTTP não suportado!"]);
}

/**
 * Processa requisições POST
 */
function handlePostRequest($diagnosisController) {
    $data = getRequestData();

    if (!isset($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'add' => $diagnosisController->addDiagnosis(
            $data['details'], 
            $data['file'], 
            $data['consult_id'], 
            $data['doctor_id']
        ),
        'update' => $diagnosisController->editDiagnosis(
            $data['id'],
            $data['details'], 
            $data['file'], 
            $data['consult_id'], 
            $data['doctor_id']
        ),
        'delete' => $diagnosisController->removeDiagnosis($data['id']),
        'byConsult' => $diagnosisController->getDiagnosesByConsult($data['consult_id']),
        'byDoctor' => $diagnosisController->getDiagnosesByDoctor($data['doctor_id']),
        'byPatient' => $diagnosisController->getDiagnosesByPatient($data['patient_id']),
        'consults' => $diagnosisController->getAllConsults(),
        'doctors' => $diagnosisController->getAllDoctors(),
        default => ["status" => "error", "message" => "Ação inválida!"]
    };

    sendResponse($response);
}

/**
 * Processa requisições GET
 */
function handleGetRequest($diagnosisController) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);
        $response = $diagnosisController->getDiagnosisById($id);
    } elseif (isset($_GET['consult_id']) && is_numeric($_GET['consult_id'])) {
        $consult_id = intval($_GET['consult_id']);
        $response = $diagnosisController->getDiagnosesByConsult($consult_id);
    } elseif (isset($_GET['doctor_id']) && is_numeric($_GET['doctor_id'])) {
        $doctor_id = intval($_GET['doctor_id']);
        $response = $diagnosisController->getDiagnosesByDoctor($doctor_id);
    } elseif (isset($_GET['patient_id']) && is_numeric($_GET['patient_id'])) {
        $patient_id = intval($_GET['patient_id']);
        $response = $diagnosisController->getDiagnosesByPatient($patient_id);
    } elseif (isset($_GET['consults']) && $_GET['consults'] === 'true') {
        $response = $diagnosisController->getAllConsults();
    } elseif (isset($_GET['doctors']) && $_GET['doctors'] === 'true') {
        $response = $diagnosisController->getAllDoctors();
    } else {
        $response = $diagnosisController->listDiagnoses();
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
