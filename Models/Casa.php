<?php
namespace Models;

/**
 * Classe que representa uma Casa no sistema
 * Implementa a interface Locavel definida em Imovel.php
 */
class Casa extends Imovel implements Locavel {
    /**
     * Calcula o valor do aluguel para a Casa
     * 
     * @param int $dias Quantidade de dias de aluguel
     * @return float Valor total do aluguel
     */
    public function calcularAluguel(int $dias): float {
        return $dias * DIARIA_CASA;
    }

    /**
     * Método para alugar a Casa
     * 
     * @return string Mensagem de resultado da operação
     */
    public function alugar(): string {
        if ($this->disponivel) {
            $this->disponivel = false;
            return "Casa '{$this->endereco}' alugada com sucesso!";
        }
        return "Casa '{$this->endereco}' não está disponível.";
    }

    /**
     * Método para devolver a Casa à imobiliária
     * 
     * @return string Mensagem de resultado da operação
     */
    public function devolver(): string {
        if (!$this->disponivel) {
            $this->disponivel = true;
            return "Casa '{$this->endereco}' devolvida com sucesso!";
        }
        return "Casa '{$this->endereco}' já está na imobiliária.";
    }
}