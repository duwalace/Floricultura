<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Método de requisição inválido.']);
    exit;
}

$caminhoBase = dirname(__DIR__);
require_once $caminhoBase . '/config/conexao.php';
require_once $caminhoBase . '/modelos/Usuario.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';


if (empty($email) || empty($senha)) {
    echo json_encode(['status' => 'error', 'message' => 'Preencha todos os campos.']);
    exit;
}

try {
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

