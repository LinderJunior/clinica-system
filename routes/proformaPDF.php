<?php
// Configuração de erro
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/ProformaPDF.php';

// Verificar se foi passado o ID da proforma
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    die('ID da proforma não fornecido ou inválido');
}

$proformaId = intval($_GET['id']);
$action = $_GET['action'] ?? 'view'; // view, download, preview

try {
    switch ($action) {
        case 'download':
            // Download do PDF
            generateProformaPDF($proformaId, 'D');
            break;
            
        case 'preview':
            // Preview inline no browser
            generateProformaPDF($proformaId, 'I');
            break;
            
        case 'view':
        default:
            // Visualização inline no browser
            generateProformaPDF($proformaId, 'I');
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
