<?php
namespace Models;

/**
 * Classe que representa um Casa no sistema
 * Implementa a interface Locavel definida em imovel.php
 */
class Casa extends imovel implements Locavel {
    /**
     * Calcula o valor do aluguel para o Casa
     * 
     * @param int $dias Quantidade de dias de aluguel
     * @return float Valor total do aluguel
     */
    public function calcularAluguel(int $dias): float {
        return $dias * DIARIA_CASA;
    }

    /**
     * Método para alugar o Casa
     * 
     * @return string Mensagem de resultado da operação
     */
    public function alugar(): string {
        if ($this->disponivel) {
            $this->disponivel = false;
            return "'{$this->tipo}' alugada com sucesso!";
        }
        return "essa '{$this->tipo}' não está disponível.";
    }

    /**
     * Método para devolver o Casa à imobiliaria
     * 
     * @return string Mensagem de resultado da operação
     */
    public function devolver(): string {
        if (!$this->disponivel) {
            $this->disponivel = true;
            return " '{$this->tipo}' entregue com sucesso!";
        }
        return "Casa '{$this->tipo}' já está na imobiliaria.";
    }
}