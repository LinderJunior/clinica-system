<?php

// Configuração de erro e cabeçalho JSON
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/RecipeService.php';

// Instância do controlador de receitas médicas
$recipeController = new RecipeController($pdo);

// Método HTTP da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Função para obter os dados do corpo da requisição
function getRequestData() {
    return json_decode(file_get_contents("php://input"), true) ?? [];
}

// Manipulação da requisição
switch ($method) {
    case 'POST':
        handlePostRequest($recipeController);
        break;
    case 'GET':
        handleGetRequest($recipeController);
        break;
    default:
        sendResponse(["status" => "error", "message" => "Método HTTP não suportado!"]);
}

/**
 * Processa requisições POST
 */
function handlePostRequest($recipeController) {
    $data = getRequestData();

    if (!isset($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'add' => $recipeController->addRecipe(
            $data['date'], 
            $data['consult_id'], 
            $data['medications'] // Array de medicações com qty, dosage e medication_id
        ),
        'update' => $recipeController->editRecipe(
            $data['id'],
            $data['date'], 
            $data['consult_id'], 
            $data['medications'] // Array de medicações com qty, dosage e medication_id
        ),
        'delete' => $recipeController->removeRecipe($data['id']),
        'byConsult' => $recipeController->getRecipesByConsult($data['consult_id']),
        'byMedication' => $recipeController->getRecipesByMedication($data['medication_id']),
        'byPatient' => $recipeController->getRecipesByPatient($data['patient_id']),
        'byDoctor' => $recipeController->getRecipesByDoctor($data['doctor_id']),
        'byDate' => $recipeController->getRecipesByDate($data['date']),
        'consults' => $recipeController->getAllConsults(),
        'medications' => $recipeController->getAllMedications(),
        'checkStock' => $recipeController->checkMedicationStock($data['medication_id']),
        default => ["status" => "error", "message" => "Ação inválida!"]
    };

    sendResponse($response);
}

/**
 * Processa requisições GET
 */
function handleGetRequest($recipeController) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);
        $response = $recipeController->getRecipeById($id);
    } elseif (isset($_GET['consult_id']) && is_numeric($_GET['consult_id'])) {
        $consult_id = intval($_GET['consult_id']);
        $response = $recipeController->getRecipesByConsult($consult_id);
    } elseif (isset($_GET['medication_id']) && is_numeric($_GET['medication_id'])) {
        $medication_id = intval($_GET['medication_id']);
        if (isset($_GET['check_stock']) && $_GET['check_stock'] === 'true') {
            $response = $recipeController->checkMedicationStock($medication_id);
        } else {
            $response = $recipeController->getRecipesByMedication($medication_id);
        }
    } elseif (isset($_GET['patient_id']) && is_numeric($_GET['patient_id'])) {
        $patient_id = intval($_GET['patient_id']);
        $response = $recipeController->getRecipesByPatient($patient_id);
    } elseif (isset($_GET['doctor_id']) && is_numeric($_GET['doctor_id'])) {
        $doctor_id = intval($_GET['doctor_id']);
        $response = $recipeController->getRecipesByDoctor($doctor_id);
    } elseif (isset($_GET['date']) && !empty($_GET['date'])) {
        $date = htmlspecialchars($_GET['date']);
        $response = $recipeController->getRecipesByDate($date);
    } elseif (isset($_GET['consults']) && $_GET['consults'] === 'true') {
        $response = $recipeController->getAllConsults();
    } elseif (isset($_GET['medications']) && $_GET['medications'] === 'true') {
        $response = $recipeController->getAllMedications();
    } else {
        $response = $recipeController->listRecipes();
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
