<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/PatientPDF.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    die('ID do paciente inválido ou não fornecido');
}

$patientId = intval($_GET['id']);
$action = $_GET['action'] ?? 'view';

try {
    switch ($action) {
        case 'download':
            generatePatientPDF($patientId, 'D');
            break;
        case 'preview':
            generatePatientPDF($patientId, 'I');
            break;
        case 'save':
            generatePatientPDF($patientId, 'F');
            break;
        default:
            generatePatientPDF($patientId, 'I');
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao gerar PDF: ' . $e->getMessage()
    ]);
}
?>