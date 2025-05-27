
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Imóveis Flexíveis.</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Estilos customizados -->
    <!-- <link href="css/styles.css" rel="stylesheet"> -->

    <style>

        .form-label {
            margin-left: 50px;
        }

        .middle {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }
        button {
            width: 50vh;
        }
        .login-container {
            margin-top: 15vh;
        }
        
        .container {
           
            display: flex;
            flex-direction: row;
            justify-content: center;
            max-width: 800px;
            /* margin: 0 auto; */
            background: white;
            padding: 20px;
        
        }


     
        .mb-3 {
            display: flex;
            flex-direction: column;
            
        }

        input[type="text"], input[type="password"] {
            width: 70%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>

    <?php 

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

        session_start();

    use services/Auth.php;

    $mensagem = '';
    $auth = new Auth();

    // se ja estiver logado, redireciona para o index
    if (auth::verficarLogin()) {
        header('location:../pagina-inicial.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD']== 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

        if ($auth->Login($username, $password)) {
            header('Location: ../pagina-inicial.php');
            exit;
        }
     }



    

    ?>


</head>
<body>
    <div class="container">
        <div class="login">
            <!-- <div style=" margin-top: 70px; height: 100%; display: flex; justify-content: center; padding: 8px;" > -->

            <div class="bg-light">
                <div class="login-container">
                    <div style="width: 400px;" class="card-shadow">
                        <!-- Cabeçalho do card de login -->
                        <div style="background-color: #003b8b; padding: 5px;" class="card-header text-white">
                            <h4 class="mb-0" style="text-align: center;"><i class="bi bi-person-lock me-2"></i>Login</h4>
                        </div>
                        <!-- Corpo do card de login -->
                        <div class="card-body container " style="background-color: #b9bbf1;">
                            <!-- Espaço para mensagem de erro (vazio por padrão) -->
                            <div id="errorMessage" class="alert alert-danger d-none"> Mensagem de erro aparecerá aqui.</div>
                            <!-- Formulário de login -->
                            <form id="loginForm" method="post" action="pagina inicial.php">
                                <!-- Campo de Usuário -->
                                <div class="mb-3">
                                    <label for="username" class="form-label" style="align-content: end; width: 350px;">
                                        <i class="bi bi-person me-1"></i>Usuário/email
                                    </label>

                                    <div class="middle">
                                    <input type="text" id="username" name="username" 
                                    class="form-control">
                                    </div>
                                </div>

                                <!-- Campo de senha -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-key me-1"></i> Senha
                                    </label>
                                    <div class="middle">
                                    <input type="password" id="password" name="password" 
                                    class="form-control">
                                    </div>
                                </div>
                                <!-- Botão de envio -->
                                 <div class="middle">
                                <button style="background-color: #003b8b; color: white;" type="submit" class="btn btn ">
                                <i class="bi bi-box-arrow-in-right me-1" style="color: white;"></i> Entrar
                            </div>
                            </button>
                                <div style="align-items: center; margin-top: 10px; margin-bottom: 0; display: flex; flex-direction: column; justify-content: center;">
                                <span style="text-align: center;"> Nao tem uma conta?</span>
                                <span style="text-align: center;"><a href="cadastro.php">Crie</a> uma!</span>
                                </div>
                            </form>

                            
                        </div>

                        <!-- Rodapé do card de login -->
                        <div class="card-footer text-center" style="background-color: #afb1ec;">©
                            <small class="text-muted">Sistema de Aluguel de Imóveis Flexíveis. <span
                                id="ano-atual"> 2025
                            </span></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts customizados -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validação do formulário usando Bootstrap
        (function() {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>

