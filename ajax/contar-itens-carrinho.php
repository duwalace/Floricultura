<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['quantidade' => 0]);
    exit;
}

require_once '../modelos/Carrinho.php';

$carrinho = new Carrinho();
echo json_encode(['quantidade' => $carrinho->getQuantidadeItens()]);
?>

