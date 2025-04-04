<?php
session_start();

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../modelos/Usuario.php';

$id = $_GET['id'] ?? 0;

// Não permite excluir o próprio usuário
if ($id == $_SESSION['usuario']['id']) {
    $_SESSION['mensagem'] = 'Você não pode excluir seu próprio usuário.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: usuarios.php');
    exit;
}

$usuario = Usuario::buscarPorId($id);

if (!$usuario) {
    header('Location: usuarios.php');
    exit;
}

// Exclui o usuário
if (Usuario::excluir($id)) {
    $_SESSION['mensagem'] = 'Usuário excluído com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao excluir usuário.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: usuarios.php');
exit;
?>

