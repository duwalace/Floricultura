<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../modelos/Usuario.php';

$usuarios = Usuario::listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Floricultura</title>
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
                    <h1 class="h2">Gerenciar Usuários</h1>
                    <a href="adicionar-usuario.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Adicionar Usuário
                    </a>
                </div>
                
                <?php if (isset($_SESSION['mensagem'])): ?>
                <div class="alert alert-<?= $_SESSION['tipo_mensagem'] ?>">
                    <?= $_SESSION['mensagem'] ?>
                </div>
                <?php 
                    unset($_SESSION['mensagem']);
                    unset($_SESSION['tipo_mensagem']);
                endif; 
                ?>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-users me-1"></i>
                        Lista de Usuários
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Tipo</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($usuarios as $usuario): ?>
                                    <tr>
                                        <td><?= $usuario['id'] ?></td>
                                        <td><?= $usuario['nome'] ?></td>
                                        <td><?= $usuario['email'] ?></td>
                                        <td>
                                            <span class="badge bg-<?= $usuario['tipo'] === 'admin' ? 'danger' : 'success' ?>">
                                                <?= $usuario['tipo'] === 'admin' ? 'Administrador' : 'Usuário' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="editar-usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if ($usuario['id'] != $_SESSION['usuario']['id']): ?>
                                            <a href="excluir-usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($usuarios)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum usuário encontrado.</td>
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

