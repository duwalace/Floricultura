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
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Validar os dados
if (empty($email) || empty($senha)) {
    echo json_encode(['status' => 'error', 'message' => 'Preencha todos os campos.']);
    exit;
}

try {
    // Verificação especial para o admin
    if ($email === 'admin@floricultura.com' && $senha === 'admin123') {
        $_SESSION['usuario'] = [
            'id' => 1,
            'nome' => 'Administrador',
            'email' => 'admin@floricultura.com',
            'tipo' => 'admin'
        ];
        
        echo json_encode(['status' => 'success', 'message' => 'Login realizado com sucesso!']);
        exit;
    }
    
    // Verificação normal para outros usuários
    $usuario = new Usuario();
    
    if ($usuario->autenticar($email, $senha)) {
        $_SESSION['usuario'] = [
            'id' => $usuario->getId(),
            'nome' => $usuario->getNome(),
            'email' => $usuario->getEmail(),
            'tipo' => $usuario->getTipo()
        ];
        
        echo json_encode(['status' => 'success', 'message' => 'Login realizado com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email ou senha incorretos.']);
    }
} catch (Exception $e) {
    // Log do erro para depuração
    error_log('Erro no login: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Erro interno do servidor. Tente novamente mais tarde.']);
}
?>

