<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

require_once 'modelos/Usuario.php';

$erro = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro = 'Preencha todos os campos.';
    } else {

        if ($email === 'admin@floricultura.com' && $senha === 'admin123') {
            $_SESSION['usuario'] = [
                'id' => 1,
                'nome' => 'Administrador',
                'email' => 'admin@floricultura.com',
                'tipo' => 'admin'
            ];
            
            header('Location: index.php');
            exit;
        }

        $usuario = new Usuario();
        
        if ($usuario->autenticar($email, $senha)) {
            $_SESSION['usuario'] = [
                'id' => $usuario->getId(),
                'nome' => $usuario->getNome(),
                'email' => $usuario->getEmail(),
                'tipo' => $usuario->getTipo()
            ];
            
            header('Location: index.php');
            exit;
        } else {
            $erro = 'Email ou senha incorretos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Floricultura</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/estilo-novo.css">
</head>
<body>
    <?php include 'componentes/barra-navegacao.php'; ?>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h2 class="mb-0">Login</h2>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($erro): ?>
                        <div class="alert alert-danger"><?= $erro ?></div>
                        <?php endif; ?>
                        
                        <form method="post" action="">
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
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Entrar</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'componentes/rodape.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script-novo.js"></script>
</body>
</html>

