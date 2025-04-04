<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado']);
    exit;
}

require_once '../modelos/Carrinho.php';

$carrinho = new Carrinho();
$carrinho->limpar();

echo json_encode(['status' => 'success', 'message' => 'Carrinho limpo com sucesso']);
?>

