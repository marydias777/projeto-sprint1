
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
</head>

<?php


?>





<body>

    <div class="container">
        <div class="login">
            <!-- <div style=" margin-top: 70px; height: 100%; display: flex; justify-content: center; padding: 8px;" > -->

            <div class="bg-light">
                <div class="login-container">
                    <div style="width: 400px;" class="card-shadow">
                        <!-- Cabeçalho do card de login -->
                        <div style="background-color:#1754A6; padding: 5px;" class="card-header text-white">
                            <h4 class="mb-0" style="text-align: center;"><i class="bi bi-person-lock me-2"></i>Cadastro</h4>
                        </div>
                        <!-- Corpo do card de login -->
                        <div class="card-body container " style="background-color: #003B8B;">
                            <!-- Espaço para mensagem de erro (vazio por padrão) -->
                            <div id="errorMessage" class="alert alert-danger d-none"> Mensagem de erro aparecerá aqui.</div>
                            <!-- Formulário de login -->
                            <form id="loginForm" method="post" action="index.php">
                                <!-- Campo de Usuário -->
                                <div class="mb-3">
                                    <label for="username" class="form-label" style="align-content: end; color:white; width: 350px;">
                                        <i class="bi bi-person me-1"></i>Usuário/email
                                    </label>

                                    <div class="middle">
                                    <input type="text" id="username" name="username" 
                                    class="form-control">
                                    </div>
                                </div>

                                <!-- Campo de senha -->
                                <div class="mb-3">
                                    <label for="password" class="form-label" style="color:white;">
                                        <i class="bi bi-key me-1"></i> Senha
                                    </label>
                                    <div class="middle">
                                    <input type="password" id="password" name="password" 
                                    class="form-control">
                                    </div>
                                </div>
                                <!-- Botão de envio -->
                                 <div class="middle">
                                <button style="background-color: #afb1ec ; color: #003B8B;" type="submit" class="btn btn">
                                <i class="bi bi-box-arrow-in-right me-1" ></i> criar conta
                            </div>
                            </button>
                                <div style=" margin-top: 10px; display: flex; flex-direction: column; justify-content: center; color: white;">
                                <span style="text-align: center;"> Já tem uma conta?</span>
                                <span style="text-align: center;"> faça<a href="index.php"> login!</a></span>
                                </div>
                            </form>

                            
                        </div>

                        <!-- Rodapé do card de login -->
                        <div class="card-footer text-center" style="background-color: #1754A6;">©
                            <small class="text-muted" >Sistema de Aluguel de Imóveis Flexíveis. <span
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
    <script src="js/scripts.js"></script>
</body>
</html>

