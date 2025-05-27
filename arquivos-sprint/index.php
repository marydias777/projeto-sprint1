<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

session_start();

use Services\{ Auth, imobiliaria};
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

// Instancia a imobiliaria
$imobiliaria = new imobiliaria();
$mensagem = '';
$usuario = Auth::getUsuario();

// Processar requisições
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['adicionar'])) {
        if (!Auth::temPermissao('adicionar')) {
            $mensagem = "Você não tem permissão para adicionar veículos.";
            goto renderizar;
        }
        
        $endereço = $_POST['endereço'];
        $acomodaçoes = $_POST['acomodaçoes'];
        $tipo = $_POST['tipo'];


        // cria o imovel (mantem a compatibilidade com as classes existentes)

        $imovel = ($tipo == 'Casa') ? new Casa($tipo, $endereço, $acomodaçoes) : new Apartamento( $tipo, $endereço, $acomodaçoes);
        if ($locadora->adicionarimovel($imovel)) {
            $mensagem = "imovel adicionado com sucesso!";
        } else {
            $mensagem = "Erro ao adicionar imovel Verifique se as informaçoes sao únicas.";
        }

    } elseif (isset($_POST['alugar'])) {
        if (!Auth::temPermissao('alugar')) {
            $mensagem = "Você não tem permissão para alugar imoveis.";
            goto renderizar;
        }
        
        $dias = isset($_POST['dias']) ? (int)$_POST['dias'] : 1;
        $mensagem = $imobiliaria->alugarImovel($_POST[''], $dias);
    } elseif (isset($_POST['devolver'])) {
        if (!Auth::temPermissao('devolver')) {
            $mensagem = "Você não tem permissão para devolver veículos.";
            goto renderizar;
        }
        
        $mensagem = $locadora->devolverimovel($_POST['modelo']);
    } elseif (isset($_POST['deletar'])) {
        if (!Auth::temPermissao('deletar')) {
            $mensagem = "Você não tem permissão para deletar veículos.";
            goto renderizar;
        }
        
        $mensagem = $locadora->deletarimovel($_POST['modelo'], $_POST['placa']);
    } elseif (isset($_POST['calcular'])) {
        if (!Auth::temPermissao('calcular')) {
            $mensagem = "Você não tem permissão para calcular previsões.";
            goto renderizar;
        }
        
        $dias = (int)$_POST['dias_calculo'];
        $tipo = $_POST['tipo_calculo'];
        $valor = $locadora->calcularPrevisaoAluguel($tipo, $dias);
        $tipoNome = ($tipo == 'Casa') ? 'Casa' : 'Apartamento';
        $mensagem = "Previsão de valor para {$dias} dias: R$ " . number_format($valor, 2, ',', '.');
    }
}

renderizar:
// Inclui o template da view
require_once __DIR__ . '/views/template.php';