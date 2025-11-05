<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/DoctorPDF.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    die('ID do médico inválido ou não fornecido');
}

$doctorId = intval($_GET['id']);
$action = $_GET['action'] ?? 'view';

try {
    switch ($action) {
        case 'download':
            generateDoctorPDF($doctorId, 'D');
            break;
        case 'preview':
            generateDoctorPDF($doctorId, 'I');
            break;
        case 'save':
            generateDoctorPDF($doctorId, 'F');
            break;
        default:
            generateDoctorPDF($doctorId, 'I');
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