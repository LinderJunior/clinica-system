<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/ConsultPDF.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    die('ID da consulta inválido ou não fornecido');
}

$consultId = intval($_GET['id']);
$action = $_GET['action'] ?? 'view';

try {
    switch ($action) {
        case 'download':
            generateConsultPDF($consultId, 'D');
            break;
        case 'preview':
            generateConsultPDF($consultId, 'I');
            break;
        case 'save':
            generateConsultPDF($consultId, 'F');
            break;
        default:
            generateConsultPDF($consultId, 'I');
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