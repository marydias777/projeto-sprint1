<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

session_start();

use Services\{Auth, Imobiliaria};
use Models\{Casa, Apartamento};

// Verificar se está logado
if (!Auth::verificarLogin()) {
    header('Location: public/login.php');
    exit;
}

// Processar logout
if (isset($_GET['logout'])) {
    (new Auth())->logout(); 
    header('Location: public/login.php');
    exit;
}

// Instancia a imobiliária
$imobiliaria = new Imobiliaria();
$mensagem = '';
$usuario = Auth::getUsuario();

// Processar requisições
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['adicionar'])) {
        if (!Auth::temPermissao('adicionar')) {
            $mensagem = "Você não tem permissão para adicionar imóveis.";
            goto renderizar;
        }
        
        $endereco = $_POST['endereco'] ?? '';
        $acomodacoes = $_POST['acomodacoes'] ?? '';
        $tipo = $_POST['tipo'] ?? '';

        if (empty($endereco) || empty($acomodacoes) || empty($tipo)) {
            $mensagem = "Todos os campos são obrigatórios.";
            goto renderizar;
        }

        // Cria o imóvel baseado no tipo
        $imovel = ($tipo == 'Casa') ? 
            new Casa($endereco, $tipo, $acomodacoes) : 
            new Apartamento($endereco, $tipo, $acomodacoes);
            
        if ($imobiliaria->adicionarImovel($imovel)) {
            $mensagem = "Imóvel adicionado com sucesso!";
        } else {
            $mensagem = "Erro ao adicionar imóvel. Verifique se as informações são únicas.";
        }

    } elseif (isset($_POST['alugar'])) {
        if (!Auth::temPermissao('alugar')) {
            $mensagem = "Você não tem permissão para alugar imóveis.";
            goto renderizar;
        }
        
        $dias = isset($_POST['dias']) ? (int)$_POST['dias'] : 1;
        $endereco = $_POST['endereco'] ?? '';
        
        if (empty($endereco)) {
            $mensagem = "Endereço é obrigatório para aluguel.";
            goto renderizar;
        }
        
        $mensagem = $imobiliaria->alugarImovel($endereco, $dias);
        
    } elseif (isset($_POST['devolver'])) {
        if (!Auth::temPermissao('devolver')) {
            $mensagem = "Você não tem permissão para devolver imóveis.";
            goto renderizar;
        }
        
        $endereco = $_POST['endereco'] ?? '';
        
        if (empty($endereco)) {
            $mensagem = "Endereço é obrigatório para devolução.";
            goto renderizar;
        }
        
        $mensagem = $imobiliaria->devolverImovel($endereco);
        
    } elseif (isset($_POST['deletar'])) {
        if (!Auth::temPermissao('deletar')) {
            $mensagem = "Você não tem permissão para deletar imóveis.";
            goto renderizar;
        }
        
        $endereco = $_POST['endereco'] ?? '';
        
        if (empty($endereco)) {
            $mensagem = "Endereço é obrigatório para exclusão.";
            goto renderizar;
        }
        
        $mensagem = $imobiliaria->deletarImovel($endereco);
        
    } elseif (isset($_POST['calcular'])) {
        if (!Auth::temPermissao('calcular')) {
            $mensagem = "Você não tem permissão para calcular previsões.";
            goto renderizar;
        }
        
        $dias = (int)$_POST['dias_calculo'];
        $tipo = $_POST['tipo_calculo'];
        
        if (empty($tipo) || $dias <= 0) {
            $mensagem = "Tipo e quantidade de dias são obrigatórios para cálculo.";
            goto renderizar;
        }
        
        $valor = $imobiliaria->calcularPrevisaoAluguel($tipo, $dias);
        $mensagem = "Previsão de valor para {$dias} dias: R$ " . number_format($valor, 2, ',', '.');
    }
}

renderizar:
// Inclui o template da view
require_once __DIR__ . '/views/template.php';