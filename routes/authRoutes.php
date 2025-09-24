<?php

// Configuração de erro e cabeçalho JSON
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Inclusão dos arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/services/AuthService.php';

// Método HTTP da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Função para obter os dados do corpo da requisição (aceita JSON e form-data)
function getRequestData() {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    $raw = file_get_contents('php://input');
    $data = [];

    // Se for JSON válido
    if ($raw !== false && stripos($contentType, 'application/json') !== false) {
        $decoded = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $data = $decoded;
        }
    }

    // Fallback para POST (form-data / x-www-form-urlencoded)
    if (!$data || !is_array($data)) {
        $data = $_POST ?? [];
    }

    // Trimming de chaves/valores de string
    if (is_array($data)) {
        $clean = [];
        foreach ($data as $k => $v) {
            $clean[is_string($k) ? trim($k) : $k] = is_string($v) ? trim($v) : $v;
        }
        $data = $clean;
    }

    return $data ?: [];
}

// Manipulação da requisição
switch ($method) {
    case 'POST':
        handlePostRequest();
        break;
    default:
        sendResponse(["status" => "error", "message" => "Método HTTP não suportado!"]);
}

/**
 * Processa requisições POST
 */
function handlePostRequest() {
    $data = getRequestData();

    // Normalizar campos esperados (tolerância a typos comuns)
    $data['action']   = $data['action']   ?? ($data['acao']   ?? ($data['type'] ?? ''));
    $data['username'] = $data['username'] ?? ($data['user']    ?? ($data['uname'] ?? ''));
    $data['password'] = $data['password'] ?? ($data['pasoword'] ?? ($data['pasword'] ?? ($data['pwd'] ?? '')));

    // Log para depuração (após normalização)
    error_log('Dados recebidos (normalizados): ' . json_encode($data));

    if (empty($data['action'])) {
        sendResponse(["status" => "error", "message" => "Nenhuma ação foi definida!"]);
        return;
    }

    $response = match ($data['action']) {
        'login'  => handleLogin($data['username'], $data['password']),
        'logout' => handleLogout(),
        'check'  => checkAuth(),
        default  => ["status" => "error", "message" => "Ação inválida!"]
    };

    sendResponse($response);
}

/**
 * Envia a resposta como JSON
 */
function sendResponse($response) {
    echo json_encode($response);
    exit;
}

/**
 * Processa a requisição de login
 */
function handleLogin($username, $password) {
    // Log para depuração
    error_log('Tentativa de login para usuário: ' . $username);
    
    if (empty($username) || empty($password)) {
        error_log('Erro: Nome de usuário ou senha vazios');
        return ["status" => "error", "message" => "Nome de usuário e senha são obrigatórios!"];
    }

    try {
        $role_id = AuthService::login($username, $password);
        error_log('Resultado do login: ' . ($role_id ? 'Sucesso (role_id: ' . $role_id . ')' : 'Falha'));
        
        if ($role_id) {
            return [
                "status" => "success", 
                "message" => "Login realizado com sucesso!",
                "role_id" => $role_id,
                "redirect" => "dashboard.php"
            ];
        } else {
            return ["status" => "error", "message" => "Credenciais inválidas. Tente novamente."];
        }
    } catch (Exception $e) {
        error_log('Exceção durante o login: ' . $e->getMessage());
        return ["status" => "error", "message" => "Erro no servidor: " . $e->getMessage()];
    }
}

/**
 * Processa a requisição de logout
 */
function handleLogout() {
    session_start();
    session_unset();
    session_destroy();
    return ["status" => "success", "message" => "Logout realizado com sucesso!"];
}

/**
 * Verifica se o usuário está autenticado
 */
function checkAuth() {
    session_start();
    if (isset($_SESSION['id'])) {
        return [
            "status" => "success", 
            "message" => "Usuário autenticado",
            "user" => [
                "id" => $_SESSION['id'],
                "username" => $_SESSION['username'],
                "role_id" => $_SESSION['role_id']
            ]
        ];
    } else {
        return ["status" => "error", "message" => "Usuário não autenticado"];
    }
}
?>
