<?php

// Configuração de erro e cabeçalho JSON
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/ConsultService.php';

// Instância do controlador de consultas
$consultController = new ConsultController($pdo);

// Método HTTP da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Função para obter os dados do corpo da requisição
function getRequestData() {
    return json_decode(file_get_contents("php://input"), true) ?? [];
}

// Manipulação da requisição
switch ($method) {
    case 'POST':
        handlePostRequest($consultController);
        break;
    case 'GET':
        handleGetRequest($consultController);
        break;
    default:
        sendResponse(["status" => "error", "message" => "Método HTTP não suportado!"]);
}

/**
 * Processa requisições POST
 */
function handlePostRequest($consultController) {
    $data = getRequestData();

    if (!isset($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'add' => $consultController->addConsult(
            $data['date'], 
            $data['time'], 
            $data['type'], 
            $data['status'], 
            $data['patient_id'], 
            $data['doctor_id']
        ),
        'update' => $consultController->editConsult(
            $data['id'],
            $data['date'], 
            $data['time'], 
            $data['type'], 
            $data['status'], 
            $data['patient_id'], 
            $data['doctor_id']
        ),
        'delete' => $consultController->removeConsult($data['id']),
        'searchByDate' => $consultController->searchConsultsByDate($data['date']),
        'searchByPatient' => $consultController->searchConsultsByPatient($data['patient_id']),
        'searchByDoctor' => $consultController->searchConsultsByDoctor($data['doctor_id']),
        'searchByStatus' => $consultController->searchConsultsByStatus($data['status']),
        'patients' => $consultController->getAllPatients(),
        'doctors' => $consultController->getAllDoctors(),
        'dashboard_doctor' => $consultController->getDoctorDashboard($data['doctor_id']),
        default => ["status" => "error", "message" => "Ação inválida!"]
    };

    sendResponse($response);
}


/**
 * Processa requisições GET
 */
function handleGetRequest($consultController) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);
        $response = $consultController->getConsultById($id);
    } elseif (isset($_GET['date']) && !empty($_GET['date'])) {
        $date = htmlspecialchars($_GET['date']);
        $response = $consultController->searchConsultsByDate($date);
    } elseif (isset($_GET['patient_id']) && is_numeric($_GET['patient_id'])) {
        $patient_id = intval($_GET['patient_id']);
        $response = $consultController->searchConsultsByPatient($patient_id);
    } elseif (isset($_GET['doctor_id']) && is_numeric($_GET['doctor_id'])) {
        $doctor_id = intval($_GET['doctor_id']);
        $response = $consultController->searchConsultsByDoctor($doctor_id);
    } elseif (isset($_GET['status']) && is_numeric($_GET['status'])) {
        $status = intval($_GET['status']);
        $response = $consultController->searchConsultsByStatus($status);
    } elseif (isset($_GET['patients']) && $_GET['patients'] === 'true') {
        $response = $consultController->getAllPatients();
    } elseif (isset($_GET['doctors']) && $_GET['doctors'] === 'true') {
        $response = $consultController->getAllDoctors();

    } else {
        $response = $consultController->listConsults();
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