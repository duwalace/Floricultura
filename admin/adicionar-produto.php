<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../modelos/Produto.php';

$erro = '';
$sucesso = '';
$nome = '';
$descricao = '';
$preco = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? '';
    
    if (empty($nome) || empty($descricao) || empty($preco)) {
        $erro = 'Preencha todos os campos obrigatórios.';
    } else {
        $produto = new Produto(null, $nome, $descricao, $preco);
        
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $nomeArquivo = time() . '_' . $_FILES['imagem']['name'];
            $caminhoTemp = $_FILES['imagem']['tmp_name'];
            $caminhoDestino = '../uploads/' . $nomeArquivo;

            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['imagem']['type'], $tiposPermitidos)) {
                $erro = 'Tipo de arquivo não permitido. Envie apenas imagens (JPG, PNG, GIF).';
            } else {

                if (move_uploaded_file($caminhoTemp, $caminhoDestino)) {
                    $produto->setImagem($nomeArquivo);
                } else {
                    $erro = 'Erro ao fazer upload da imagem.';
                }
            }
        }
        
        if (empty($erro)) {
            if ($produto->cadastrar()) {
                $sucesso = 'Produto cadastrado com sucesso!';
                $nome = '';
                $descricao = '';
                $preco = '';
            } else {
                $erro = 'Erro ao cadastrar produto. Tente novamente.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto - Floricultura</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include 'componentes/barra-navegacao.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <?php include 'componentes/menu-lateral.php'; ?>
            </div>
            
            <main class="col-md-9 col-sm-12 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Adicionar Produto</h1>
                </div>
                
                <?php if ($erro): ?>
                <div class="alert alert-danger"><?= $erro ?></div>
                <?php endif; ?>
                
                <?php if ($sucesso): ?>
                <div class="alert alert-success"><?= $sucesso ?></div>
                <?php endif; ?>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-plus me-1"></i>
                        Novo Produto
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-md-6 col-sm-12">
                                    <label for="nome" class="form-label">Nome do Produto *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>" required>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="preco" class="form-label">Preço *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" class="form-control" id="preco" name="preco" step="0.01" min="0" value="<?= htmlspecialchars($preco) ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição *</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="4" required><?= htmlspecialchars($descricao) ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="imagem" class="form-label">Imagem do Produto</label>
                                <input type="file" class="form-control" id="imagem" name="imagem">
                                <div class="form-text">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB.</div>
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2">
                                <a href="produtos.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Salvar Produto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/admin.js"></script>
</body>
</html>

