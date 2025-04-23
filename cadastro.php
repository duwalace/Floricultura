<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

require_once 'modelos/Usuario.php';

$erro = '';
$sucesso = '';
$nome = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';
    
    if (empty($nome) || empty($email) || empty($senha) || empty($confirmarSenha)) {
        $erro = 'Preencha todos os campos.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } elseif ($senha !== $confirmarSenha) {
        $erro = 'As senhas não coincidem.';
    } elseif (Usuario::emailExiste($email)) {
        $erro = 'Este email já está cadastrado.';
    } else {
        $usuario = new Usuario(null, $nome, $email, $senha);
        
        if ($usuario->cadastrar()) {
            $sucesso = 'Cadastro realizado com sucesso! Faça login para continuar.';
            $nome = '';
            $email = '';
        } else {
            $erro = 'Erro ao cadastrar. Tente novamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Floricultura</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
    <?php include 'componentes/barra-navegacao.php'; ?>
    
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h2 class="mb-0">Cadastro</h2>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($erro): ?>
                        <div class="alert alert-danger"><?= $erro ?></div>
                        <?php endif; ?>
                        
                        <?php if ($sucesso): ?>
                        <div class="alert alert-success"><?= $sucesso ?></div>
                        <div class="text-center mt-3">
                            <a href="login.php" class="btn btn-primary">Ir para Login</a>
                        </div>
                        <?php else: ?>
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="senha" name="senha" required>
                                    <button type="button" class="btn btn-outline-secondary mostrar-senha">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text">A senha deve ter pelo menos 6 caracteres.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="confirmar_senha" class="form-label">Confirmar Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                                    <button type="button" class="btn btn-outline-secondary mostrar-senha">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </form>
                        <?php endif; ?>
                        
                        <div class="text-center mt-3">
                            <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'componentes/rodape.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>

