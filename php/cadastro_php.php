<?php
session_start();
include 'conexao.php'; // Arquivo de conexão com o banco de dados

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha para segurança
    $tipo = trim($_POST['tipo']); // Novo campo: tipo de usuário

    if (empty($nome) || empty($email) || empty($_POST['senha']) || empty($tipo)) {
        echo json_encode(['sucesso' => false, 'erro' => 'Todos os campos são obrigatórios.']);
        exit;
    }

    // Verifica se o email já existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $stmt->fetch();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['sucesso' => false, 'erro' => 'E-mail já cadastrado.']);
        exit;
    }

    // Insere o novo usuário
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':tipo', $tipo);
    
    if ($stmt->execute()) {
        $_SESSION['nome_usuario'] = $nome;
        $_SESSION['tipo_usuario'] = $tipo; // Define o tipo na sessão
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'Erro ao cadastrar.']);
    }
} else {
    echo json_encode(['sucesso' => false, 'erro' => 'Método inválido.']);
}
?>