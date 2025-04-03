<?php
include 'conexao.php'; // Inclui o arquivo de conexão

$sql = "SELECT * FROM produtos"; // Consulta SQL para buscar todos os produtos
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <style>
        .produto {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            width: 250px;
            display: inline-block;
            text-align: center;
        }
        img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<h2>Lista de Produtos</h2>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='produto'>";
        echo "<img src='" . $row['imagem'] . "' alt='" . $row['nome'] . "'>";
        echo "<h3>" . $row['nome'] . "</h3>";
        echo "<p>" . $row['descricao'] . "</p>";
        echo "<p><strong>Preço: R$ " . number_format($row['preco'], 2, ',', '.') . "</strong></p>";
        echo "</div>";
    }
} else {
    echo "<p>Nenhum produto encontrado.</p>";
}
$conn->close();
?>

</body>
</html>
