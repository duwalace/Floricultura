<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    // Verifica se o usuário é admin
    if (isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] === "admin") {
        $sql = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            echo json_encode(["sucesso" => true, "produto" => $produto]);
        } else {
            echo json_encode(["sucesso" => false, "erro" => "Produto não encontrado."]);
        }
    } else {
        echo json_encode(["sucesso" => false, "erro" => "Acesso negado."]);
    }
} else {
    echo json_encode(["sucesso" => false, "erro" => "Método inválido."]);
}
?>