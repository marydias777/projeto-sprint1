<?php
namespace Models;

/**
 * Interface Locavel incorporada diretamente no arquivo.
 * Define os métodos necessários para um veículo ser locável
 */
interface Locavel {
    public function alugar(): string;
    public function devolver(): string;
    public function isDisponivel(): bool;
}

/**
 * Classe abstrata base para todos os tipos de veículos
 */
abstract class Imovel {
    protected string $tipo;
    protected string $endereço;
    protected string $acomodaçoes;
    protected bool $disponivel;
    protected ?int $id = null;

    /**
     * Construtor da classe Veiculo
     * 
     * @param string $endereço Nome/endereço do veículo
     * @param string $acomodaçoes acomodaçoes do veículo
     * @param bool $disponivel Status de disponibilidade
     * @param int|null $id ID no banco de dados (opcional)
     */
    public function __construct(string $endereço, string $acomodaçoes, bool $disponivel = true, ?int $id = null) {
        $this->tipo = $tipo;
        $this->endereço = $endereço;
        $this->acomodaçoes = $acomodaçoes;
        $this->disponivel = $disponivel;
        $this->id = $id;
    }

    /**
     * Calcula o valor do aluguel baseado na quantidade de dias
     * Método abstrato a ser implementado pelas classes filhas
     * 
     * @param int $dias Quantidade de dias de aluguel
     * @return float Valor total do aluguel
     */
    abstract public function calcularAluguel(int $dias): float;

    /**
     * Verifica se o veículo está disponível para aluguel
     * 
     * @return bool Status de disponibilidade
     */
    public function isDisponivel(): bool {
        return $this->disponivel;
    }

    /**
     * Obtém o endereço do veículo
     * 
     * @return string endereço do veículo
     */
    public function getEndereço(): string {
        return $this->endereço;
    }

    /**
     * Obtém a acomodaçoes do veículo
     * 
     * @return string acomodaçoes do veículo
     */
    public function getAcomodaçoes(): string {
        return $this->acomodaçoes;
    }

    /**
     * Obtém o ID do veículo no banco de dados
     * 
     * @return int|null ID do veículo
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Define o status de disponibilidade do veículo
     * 
     * @param bool $disponivel Status de disponibilidade
     */
    public function setDisponivel(bool $disponivel): void {
        $this->disponivel = $disponivel;
    }

    /**
     * Define o ID do veículo (usado ao recuperar do banco)
     * 
     * @param int $id ID do veículo no banco
     */
    public function setId(int $id): void {
        $this->id = $id;
    }
}