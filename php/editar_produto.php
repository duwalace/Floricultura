<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    // Verifica se o usuário é admin
    if (isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] === "admin") {
        $sql = "UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["sucesso" => false, "erro" => "Erro ao editar o produto."]);
        }
    } else {
        echo json_encode(["sucesso" => false, "erro" => "Acesso negado."]);
    }
} else {
    echo json_encode(["sucesso" => false, "erro" => "Método inválido."]);
}
?>