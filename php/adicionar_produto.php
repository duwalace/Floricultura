<?php
session_start(); // Inicia a sessão
include 'conexao.php'; // Inclui o arquivo de conexão com o banco de dados

// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o usuário é um administrador
    if (isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] === "admin") {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];

        // Diretório de upload
        $diretorio = "../uploads/";
        $imagem = $diretorio . basename($_FILES["imagem"]["name"]);

        // Verifica se o arquivo foi enviado corretamente
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem)) {
            $imagemNome = basename($_FILES["imagem"]["name"]);
            
            // Prepara a query SQL para inserir o produto
            $sql = "INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (:nome, :descricao, :preco, :imagem)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':imagem', $imagemNome);

            // Executa a query
            if ($stmt->execute()) {
                echo json_encode(["sucesso" => true, "mensagem" => "Produto adicionado com sucesso!"]);
            } else {
                echo json_encode(["sucesso" => false, "erro" => "Erro ao adicionar produto no banco de dados."]);
            }
        } else {
            echo json_encode(["sucesso" => false, "erro" => "Erro no upload da imagem."]);
        }
    } else {
        echo json_encode(["sucesso" => false, "erro" => "Acesso negado. Somente administradores podem adicionar produtos."]);
    }
} else {
    echo json_encode(["sucesso" => false, "erro" => "Método de requisição inválido."]);
}
?>