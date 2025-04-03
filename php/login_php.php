<?php
session_start();
include("../php/conexao.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    
    // Buscar usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Verificar senha
        if (password_verify($senha, $usuario["senha"])) {
            $_SESSION["nome_usuario"] = $usuario["nome"];
            $_SESSION["tipo_usuario"] = $usuario["tipo"]; // Define o tipo na sessão
            
            echo json_encode(["sucesso" => true, "tipo" => $usuario["tipo"]]);
            exit();
        } else {
            echo json_encode(["sucesso" => false, "erro" => "Senha incorreta!"]);
            exit();
        }
    
    } else {
        echo json_encode(["sucesso" => false, "erro" => "Usuário não encontrado!"]);
        exit();
    }
} else {
    echo json_encode(["sucesso" => false, "erro" => "Requisição inválida!"]);
    exit();
}
?>