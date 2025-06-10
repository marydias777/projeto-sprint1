<?php 
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

session_start();

use Services\Auth;

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        try {
            $pdo = getConnection();
            $hash = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO usuarios (username, password, perfil) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $hash, 'usuario'])) {
                $mensagem = "Conta criada com sucesso! Faça login.";
            } else {
                $mensagem = "Erro ao criar conta. Usuário pode já existir.";
            }
        } catch (PDOException $e) {
            $mensagem = "Erro ao criar conta. Usuário pode já existir.";
        }
    } else {
        $mensagem = "Todos os campos são obrigatórios.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Sistema de Imóveis</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, white, white);
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .cadastro-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 320px;
        }

        .cadastro-header {
            background: #1e3c72;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .cadastro-body {
            background: #003b8b;
            padding: 25px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: white;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1e3c72;
            box-shadow: 0 0 5px rgba(30, 60, 114, 0.3);
        }

        .btn-cadastro {
            width: 100%;
            padding: 12px;
            background: #a8a8d8;
            color: #1e3c72;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-cadastro:hover {
            background: #9999cc;
        }

        .cadastro-footer {
            text-align: center;
            margin-top: 20px;
            color: white;
            font-size: 14px;
        }

        .cadastro-footer a {
            color: #6a70f8;
            text-decoration: none;
            font-weight: bold;
        }

        .cadastro-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid;
        }

        .alert.success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .alert.error {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="cadastro-container">
        <div class="cadastro-header">
            Crie sua conta
        </div>
        
        <div class="cadastro-body">
            <?php if ($mensagem): ?>
            <div class="alert <?= strpos($mensagem, 'sucesso') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($mensagem) ?>
            </div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label for="username">Usuário/email</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-cadastro">Criar</button>
                
                <div class="cadastro-footer">
                    Já tem uma conta?<br>
                    <a href="login.php">Faça login!</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>