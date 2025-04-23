<?php
session_start();
header('Content-Type: application/json');

// Verificar se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Método de requisição inválido.']);
    exit;
}

// Incluir o arquivo de conexão e classe Usuario
$caminhoBase = dirname(__DIR__);
require_once $caminhoBase . '/config/conexao.php';
require_once $caminhoBase . '/modelos/Usuario.php';

// Capturar os dados do formulário
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$receber_ofertas = isset($_POST['receber_ofertas']) ? 1 : 0;
$receber_whatsapp = isset($_POST['receber_whatsapp']) ? 1 : 0;

if (empty($nome) || empty($email) || empty($senha) || empty($telefone)) {
    echo json_encode(['status' => 'error', 'message' => 'Preencha todos os campos obrigatórios.']);
    exit;
}

if (strlen($senha) < 6) {
    echo json_encode(['status' => 'error', 'message' => 'A senha deve ter pelo menos 6 caracteres.']);
    exit;
}

try {

    if (Usuario::emailExiste($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Este email já está cadastrado.']);
        exit;
    }

    $usuario = new Usuario(null, $nome, $email, $senha);
    
    if ($usuario->cadastrar()) {
        echo json_encode(['status' => 'success', 'message' => 'Cadastro realizado com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar. Tente novamente.']);
    }
} catch (Exception $e) {

    error_log('Erro no cadastro: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Erro interno do servidor. Tente novamente mais tarde.']);
}
?>

