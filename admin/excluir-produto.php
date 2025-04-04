<?php
session_start();

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../modelos/Produto.php';

$id = $_GET['id'] ?? 0;
$produto = Produto::buscarPorId($id);

if (!$produto) {
    header('Location: produtos.php');
    exit;
}

// Remove a imagem do produto se existir
if ($produto['imagem'] && file_exists('../uploads/' . $produto['imagem'])) {
    unlink('../uploads/' . $produto['imagem']);
}

// Exclui o produto
if (Produto::excluir($id)) {
    $_SESSION['mensagem'] = 'Produto excluído com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao excluir produto.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: produtos.php');
exit;
?>

