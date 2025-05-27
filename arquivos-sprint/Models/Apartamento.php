<?php
namespace Models;

/**
 * Classe que representa uma apartamento no sistema
 * Implementa a interface Locavel definida em imovel.php
 */
class apartamento extends imovel implements Locavel {
    /**
     * Calcula o valor do aluguel para a apartamento
     * 
     * @param int $dias Quantidade de dias de aluguel
     * @return float Valor total do aluguel
     */
    public function calcularAluguel(int $dias): float {
        return $dias * DIARIA_APARTAMENTO;
    }

    /**
     * Método para alugar a apartamento
     * 
     * @return string Mensagem de resultado da operação
     */
    public function alugar(): string {
        if ($this->disponivel) {
            $this->disponivel = false;
            return "apartamento '{$this->endereço}' alugada com sucesso!";
        }
        return "apartamento '{$this->endereço}' não está disponível.";
    }

    /**
     * Método para devolver a apartamento à imobiliaria
     * 
     * @return string Mensagem de resultado da operação
     */
    public function devolver(): string {
        if (!$this->disponivel) {
            $this->disponivel = true;
            return "apartamento '{$this->endereço}' devolvida com sucesso!";
        }
        return "apartamento '{$this->endereço}' já está na imobiliaria.";
    }
}