<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado']);
    exit;
}

require_once '../modelos/Carrinho.php';

$produtoId = $_POST['produto_id'] ?? 0;

if (!$produtoId) {
    echo json_encode(['status' => 'error', 'message' => 'Produto não especificado']);
    exit;
}

$carrinho = new Carrinho();
if ($carrinho->removerItem($produtoId)) {
    echo json_encode(['status' => 'success', 'message' => 'Item removido do carrinho']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao remover item do carrinho']);
}
?>