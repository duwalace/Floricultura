<?php
$host = "localhost";
$user = "root"; // Seu usuário do MySQL
$pass = ""; // Sua senha do MySQL (deixe vazia no XAMPP)
$db = "floricultura"; // Nome do banco de dados

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilitar exceções para erros
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>