<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];

    // Verifica se o usuário é admin
    if (isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] === "admin") {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["sucesso" => false, "erro" => "Erro ao excluir o produto."]);
        }
    } else {
        echo json_encode(["sucesso" => false, "erro" => "Acesso negado."]);
    }
} else {
    echo json_encode(["sucesso" => false, "erro" => "Método inválido."]);
}
?>