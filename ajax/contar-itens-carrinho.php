<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['quantidade' => 0]);
    exit;
}

require_once '../modelos/Carrinho.php';

$carrinho = new Carrinho();
echo json_encode(['quantidade' => $carrinho->getQuantidadeItens()]);
?>

