<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] === "admin") {
        // Validação dos dados
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
        $preco = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT);

        if (!$nome || !$descricao || !$preco) {
            echo json_encode(["sucesso" => false, "erro" => "Dados inválidos"]);
            exit;
        }

        // Validação da imagem
        $diretorio = "../uploads/";
        $extensoesPermitidas = ['jpg', 'jpeg', 'png'];
        $nomeArquivo = $_FILES["imagem"]["name"];
        $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

        if (!in_array($extensao, $extensoesPermitidas)) {
            echo json_encode(["sucesso" => false, "erro" => "Formato de imagem inválido"]);
            exit;
        }

        if ($_FILES["imagem"]["size"] > 2097152) { // 2MB
            echo json_encode(["sucesso" => false, "erro" => "Imagem muito grande (Max. 2MB)"]);
            exit;
        }

        $nomeUnico = uniqid() . '.' . $extensao;
        $destino = $diretorio . $nomeUnico;

        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $destino)) {
            try {
                $sql = "INSERT INTO produtos (nome, descricao, preco, imagem) 
                        VALUES (:nome, :descricao, :preco, :imagem)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':nome' => $nome,
                    ':descricao' => $descricao,
                    ':preco' => $preco,
                    ':imagem' => $nomeUnico
                ]);
                
                echo json_encode(["sucesso" => true, "mensagem" => "Produto adicionado com sucesso!"]);
            } catch (PDOException $e) {
                echo json_encode(["sucesso" => false, "erro" => "Erro no banco de dados: " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["sucesso" => false, "erro" => "Erro no upload da imagem"]);
        }
    } else {
        echo json_encode(["sucesso" => false, "erro" => "Acesso não autorizado"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["sucesso" => false, "erro" => "Método não permitido"]);
}
?>