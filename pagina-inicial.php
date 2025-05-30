<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Locação de Imoveis</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Estilos customizados -->
    <!-- <link href="style.css" rel="stylesheet"> -->
</head>
<body class="container py-4">
    <div class="container py-4">

        <!-- barra superior com as informaçoes do usuario -->
         <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1> Sistema de locação de Imoveis</h1>
                    <div class="d-flex align-items-center gap-3 user-info">

                        <!-- icone de usuario usando boostrap icons -->
                         <span class="user-icon">
                            <i class="bi bi-person-circle" style="font-size: 24px;"></i>
                         </span>
                         <!-- texto "bem vindo" [username] -->
                          <span class="welcome-text">Bem vindo, <strong id="username-display"> <?= htmlspecialchars($usuario['username'])?></strong></span>

                        <!-- botao para sair com icone usando boostrap icons -->
                         <a href="index.html" class="btn btn-outline-danger d-flex align-items-center gap-1">
                            <i class="bi bi-box-arrow-right"></i>
                            Sair
                         </a>

                    </div>
                </div>
            </div>
         </div>
         <!-- Mensagem de alerta (oculta por pradrao) -->
        <?php if ($mensagem): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($mensagem) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

          <!-- linha para formularios (adicionar veiculo e calcular previsao) -->
           <div class="row same-height-row">
            <!-- _________-- -->

            <div class="col-md-6" id="secao-adicionar-veiculo">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Adicionar Imovel</h4>
                    </div>
                    <div class="card-body">
                        <form id="addVehicleForm" method="post" action="">
                            <div class="mb-3">
                                <label class="form-label">Endereço</label>
                                <input type="text" name="modelo" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Acomodações(pessoas)</label>
                                <input type="text" name="placa" class="form-control">
                            </div>

                           
                            <div class="mb-3">
                                <label class="form-label">Tipo de imovel</label>
                                <select name="tipo" class="form-select">
                                    <option value="...">...</option>
                                    <option value="...">...</option>
                                </select>
                            </div>
                            <div class="button1">
                            <button type="submit" name="adicionar" class="btn w-100"><i class="bi bi-plus-lg me-1">Adicionar Imovel</i>
                            </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- formulario para calcular a previsao (visivel para todos os perfis) -->
            <div class="col-md-6" id="secao-calcular">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="bi bi-calculator me-2"></i>Calcular Previsao de Aluguel</h4>
                    </div>
                    <div class="card-body">
                        <form action="" id="calcForm" method="post">
                            <div class="mb-3">
                                <label class="form-label">Escolher imovel</label>
                                <select name="tipo_calculo" class="form-select">
                                    <option value="...">...</option>
                                    <option value="...">...</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantidade de Dias</label>
                                <input type="number" name="dias_calculo" class="form-control" value="1" min="1">

                                
                            </div>
                            <div class="button2">
                            <button class="btn w-100" type="submit" name="calcular">
                                <i class="bi bi-calculator me-1">Calcular previsao</i>
                            </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

     <!-- tabela de imoveis -->
     <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="bi bi-list-check me-2"></i>Lista de imoveis</h4>
                </div>
                <div class="card-body">
                    <div aria-multiselectable="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Tipo de imovel</th>
                                    <th>Acomodações(quartos)</th>
                                    <th>Endereço</th>
                                    <th>Ver no mapa</th>
                                    <th>Status</th>
                                    <th>Açoes</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        
                            <tbody>
                             

     <!-- rodapé -->
      <footer class="mt-5 text-center text-muted">
        <hr>
        <p>sistema de locadora de veiculos &copy <span id="ano-atual">2025</span> - 
        utilizando MySQL para persistencia de dados</p>
      </footer>


    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts customizados -->
    <script src="js/scripts.js"></script>
</body>
</html>