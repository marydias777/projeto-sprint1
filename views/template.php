<?php
use Services\Auth;

/**
 * Template principal do sistema de imobiliária
 * Recebe as variáveis $imobiliaria, $mensagem e $usuario do controller (index.php)
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Locação de Imóveis</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            font-family: Arial, sans-serif;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: #1e3c72;
            color: white;
            padding: 15px 25px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info span {
            background: white;
            color: #1e3c72;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }

        .btn-sair {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-sair:hover {
            background: white;
            color: #1e3c72;
        }

        .main-content {
            background: #e8e9f3;
            padding: 25px;
            border-radius: 0 0 8px 8px;
        }

        .cards-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: #b8b9dc;
            color: #333;
            padding: 15px;
            font-weight: bold;
            font-size: 16px;
        }

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #1e3c72;
            box-shadow: 0 0 5px rgba(30, 60, 114, 0.3);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: #b8b9dc;
            color: #333;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background: #a8a9cc;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table-header {
            background: #b8b9dc;
            color: #333;
            padding: 15px;
            font-weight: bold;
            font-size: 16px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #1e3c72;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        .table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            background: white;
        }

        .table tr:nth-child(even) td {
            background: #f8f9fa;
        }

        .table tr:hover td {
            background: #e8e9f3;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge.success {
            background: #d4edda;
            color: #155724;
        }

        .badge.warning {
            background: #fff3cd;
            color: #856404;
        }

        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .action-group {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .days-input {
            width: 60px;
            padding: 4px;
            font-size: 12px;
        }

        .alert {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #bee5eb;
        }

        @media (max-width: 768px) {
            .cards-row {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
            
            .action-group {
                flex-direction: column;
                gap: 5px;
            }
            
            .btn-action {
                width: 100%;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Cabeçalho -->
        <div class="header">
            <h1>Sistema de Locação de Imóveis</h1>
            <div class="user-info">
                <span>Bem-vindo *<?= htmlspecialchars($usuario['username']) ?>*</span>
                <a href="?logout=1" class="btn-sair">Sair</a>
            </div>
        </div>

        <!-- Conteúdo principal -->
        <div class="main-content">
            <?php if ($mensagem): ?>
            <div class="alert">
                <?= htmlspecialchars($mensagem) ?>
            </div>
            <?php endif; ?>

            <!-- Cards de formulários -->
            <div class="cards-row">
                <?php if (Auth::temPermissao('adicionar')): ?>
                <!-- Card Adicionar Imóvel -->
                <div class="card">
                    <div class="card-header">Adicionar Imóvel</div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Endereço</label>
                                <input type="text" name="endereco" placeholder="Ex: Rua das Flores, 123" required>
                            </div>
                            <div class="form-group">
                                <label>Acomodações (pessoas)</label>
                                <input type="text" name="acomodacoes" placeholder="Ex: 4 pessoas" required>
                            </div>
                            <div class="form-group">
                                <label>Tipo de imóvel</label>
                                <select name="tipo" required>
                                    <option value="">Selecione...</option>
                                    <option value="Casa">Casa</option>
                                    <option value="Apartamento">Apartamento</option>
                                </select>
                            </div>
                            <button type="submit" name="adicionar" class="btn-primary">Adicionar</button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Card Previsão do Aluguel -->
                <div class="card">
                    <div class="card-header">Previsão do Aluguel</div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Escolher imóvel</label>
                                <select name="tipo_calculo" required>
                                    <option value="">Selecione...</option>
                                    <option value="Casa">Casa (R$ <?= number_format(DIARIA_CASA, 2, ',', '.') ?>/dia)</option>
                                    <option value="Apartamento">Apartamento (R$ <?= number_format(DIARIA_APARTAMENTO, 2, ',', '.') ?>/dia)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Quantidade de dias</label>
                                <input type="number" name="dias_calculo" value="1" min="1" required>
                            </div>
                            <button type="submit" name="calcular" class="btn-primary">Calcular</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabela de imóveis -->
            <div class="table-container">
                <div class="table-header">Lista de imóveis</div>
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tipo de imóvel</th>
                                <th>Acomodações</th>
                                <th>Endereço</th>
                                <th>Ver no mapa</th>
                                <th>Status</th>
                                <?php if (Auth::temPermissao('alugar') || Auth::temPermissao('devolver') || Auth::temPermissao('deletar')): ?>
                                <th>Ações</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($imobiliaria->listarImoveis() as $imovel): ?>
                            <tr>
                                <td><?= htmlspecialchars($imovel->getTipo()) ?></td>
                                <td><?= htmlspecialchars($imovel->getAcomodacoes()) ?></td>
                                <td><?= htmlspecialchars($imovel->getEndereco()) ?></td>
                                <td>
                                    <a href="https://www.google.com/maps/dir/SENAI+Santo+André/@-23.6662511,-46.5213753,17z/<?= urlencode(htmlspecialchars($imovel->getEndereco())) ?>" target="_blank" style="color: #87CEEB; text-decoration: underline;">
                                        Ver no mapa
                                    </a>
                                </td>
                                <td>
                                    <span class="badge <?= $imovel->isDisponivel() ? 'success' : 'warning' ?>">
                                        <?= $imovel->isDisponivel() ? 'Disponível' : 'Alugado' ?>
                                    </span>
                                </td>
                                <?php if (Auth::temPermissao('alugar') || Auth::temPermissao('devolver') || Auth::temPermissao('deletar')): ?>
                                <td>
                                    <form method="post" style="display: inline-block;">
                                        <input type="hidden" name="endereco" value="<?= htmlspecialchars($imovel->getEndereco()) ?>">
                                        <div class="action-group">
                                            <?php if (Auth::temPermissao('deletar')): ?>
                                            <button type="submit" name="deletar" class="btn-action btn-danger" onclick="return confirm('Tem certeza?')">
                                                Deletar
                                            </button>
                                            <?php endif; ?>
                                            
                                            <?php if (!$imovel->isDisponivel() && Auth::temPermissao('devolver')): ?>
                                                <button type="submit" name="devolver" class="btn-action btn-warning">
                                                    Devolver
                                                </button>
                                            <?php elseif ($imovel->isDisponivel() && Auth::temPermissao('alugar')): ?>
                                                <input type="number" name="dias" class="days-input" value="1" min="1" required>
                                                <button type="submit" name="alugar" class="btn-action btn-success">
                                                    Alugar
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if (count($imobiliaria->listarImoveis()) === 0): ?>
                            <tr>
                                <td colspan="<?= (Auth::temPermissao('alugar') || Auth::temPermissao('devolver') || Auth::temPermissao('deletar')) ? '6' : '5' ?>" style="text-align: center; padding: 20px; color: #666;">
                                    Nenhum imóvel cadastrado.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>