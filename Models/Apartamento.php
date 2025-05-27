<?php
namespace Models;

/**
 * Classe que representa um Apartamento no sistema
 * Implementa a interface Locavel definida em Imovel.php
 */
class Apartamento extends Imovel implements Locavel {
    /**
     * Calcula o valor do aluguel para o Apartamento
     * 
     * @param int $dias Quantidade de dias de aluguel
     * @return float Valor total do aluguel
     */
    public function calcularAluguel(int $dias): float {
        return $dias * DIARIA_APARTAMENTO;
    }

    /**
     * Método para alugar o Apartamento
     * 
     * @return string Mensagem de resultado da operação
     */
    public function alugar(): string {
        if ($this->disponivel) {
            $this->disponivel = false;
            return "Apartamento '{$this->endereco}' alugado com sucesso!";
        }
        return "Apartamento '{$this->endereco}' não está disponível.";
    }

    /**
     * Método para devolver o Apartamento à imobiliária
     * 
     * @return string Mensagem de resultado da operação
     */
    public function devolver(): string {
        if (!$this->disponivel) {
            $this->disponivel = true;
            return "Apartamento '{$this->endereco}' devolvido com sucesso!";
        }
        return "Apartamento '{$this->endereco}' já está na imobiliária.";
    }
}