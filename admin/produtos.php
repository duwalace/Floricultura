<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../modelos/Produto.php';

$termo = $_GET['busca'] ?? '';
if (!empty($termo)) {
    $produtos = Produto::buscarPorNome($termo);
} else {
    $produtos = Produto::listarTodos();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos - Floricultura</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include 'componentes/barra-navegacao.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include 'componentes/menu-lateral.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Gerenciar Produtos</h1>
                    <a href="adicionar-produto.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Adicionar Produto
                    </a>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <i class="fas fa-table me-1"></i>
                                Lista de Produtos
                            </div>
                            <div class="col-md-4">
                                <form action="produtos.php" method="get" class="d-flex">
                                    <input type="text" name="busca" class="form-control me-2" placeholder="Buscar produtos..." value="<?= htmlspecialchars($termo) ?>">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Imagem</th>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        <th>Preço</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($produtos as $produto): ?>
                                    <tr>
                                        <td><?= $produto['id'] ?></td>
                                        <td>
                                            <img src="<?= $produto['imagem'] ? '../uploads/' . $produto['imagem'] : '../assets/img/sem-imagem.jpg' ?>" 
                                                 alt="<?= $produto['nome'] ?>" class="img-thumbnail" style="width: 50px;">
                                        </td>
                                        <td><?= $produto['nome'] ?></td>
                                        <td><?= substr($produto['descricao'], 0, 50) ?>...</td>
                                        <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                                        <td>
                                            <a href="editar-produto.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="excluir-produto.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($produtos)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Nenhum produto encontrado.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
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

