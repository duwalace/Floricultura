<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../modelos/Usuario.php';

$id = $_GET['id'] ?? 0;
$usuario = Usuario::buscarPorId($id);

if (!$usuario) {
    header('Location: usuarios.php');
    exit;
}

$erro = '';
$sucesso = '';
$nome = $usuario['nome'];
$email = $usuario['email'];
$tipo = $usuario['tipo'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';
    $tipo = $_POST['tipo'] ?? 'usuario';
    
    if (empty($nome) || empty($email)) {
        $erro = 'Preencha todos os campos obrigatórios.';
    } elseif (!empty($senha) && strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } elseif (!empty($senha) && $senha !== $confirmarSenha) {
        $erro = 'As senhas não coincidem.';
    } elseif (Usuario::emailExiste($email, $id)) {
        $erro = 'Este email já está cadastrado para outro usuário.';
    } else {
        $usuarioObj = new Usuario($id, $nome, $email, $senha, $tipo);
        
        if ($usuarioObj->atualizar()) {
            $sucesso = 'Usuário atualizado com sucesso!';

            if ($id == $_SESSION['usuario']['id']) {
                $_SESSION['usuario']['nome'] = $nome;
                $_SESSION['usuario']['email'] = $email;
                $_SESSION['usuario']['tipo'] = $tipo;
            }

            $usuario = Usuario::buscarPorId($id);
            $nome = $usuario['nome'];
            $email = $usuario['email'];
            $tipo = $usuario['tipo'];
        } else {
            $erro = 'Erro ao atualizar usuário. Tente novamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário - Floricultura</title>
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
                <div
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Editar Usuário</h1>
                </div>
                
                <?php if ($erro): ?>
                <div class="alert alert-danger"><?= $erro ?></div>
                <?php endif; ?>
                
                <?php if ($sucesso): ?>
                <div class="alert alert-success"><?= $sucesso ?></div>
                <?php endif; ?>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user-edit me-1"></i>
                        Editar Usuário #<?= $id ?>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label">Nome Completo *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="senha" class="form-label">Senha</label>
                                    <input type="password" class="form-control" id="senha" name="senha">
                                    <div class="form-text">Deixe em branco para manter a senha atual. A nova senha deve ter pelo menos 6 caracteres.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="confirmar_senha" class="form-label">Confirmar Senha</label>
                                    <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo de Usuário *</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="usuario" <?= $tipo === 'usuario' ? 'selected' : '' ?>>Usuário</option>
                                    <option value="admin" <?= $tipo === 'admin' ? 'selected' : '' ?>>Administrador</option>
                                </select>
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2">
                                <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
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

