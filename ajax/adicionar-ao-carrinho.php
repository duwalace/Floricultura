<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado']);
    exit;
}

require_once '../modelos/Carrinho.php';

$produtoId = $_POST['produto_id'] ?? 0;
$quantidade = $_POST['quantidade'] ?? 1;

if (!$produtoId) {
    echo json_encode(['status' => 'error', 'message' => 'Produto não especificado']);
    exit;
}

$carrinho = new Carrinho();
if ($carrinho->adicionarItem($produtoId, $quantidade)) {
    echo json_encode(['status' => 'success', 'message' => 'Produto adicionado ao carrinho']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao adicionar produto ao carrinho']);
}
?>

