<?php
namespace Models;

/**
 * Interface Locavel incorporada diretamente no arquivo.
 * Define os métodos necessários para um imóvel ser locável
 */
interface Locavel {
    public function alugar(): string;
    public function devolver(): string;
    public function isDisponivel(): bool;
}

/**
 * Classe abstrata base para todos os tipos de imóveis
 */
abstract class Imovel {
    protected string $tipo;
    protected string $endereco;
    protected string $acomodacoes;
    protected bool $disponivel;
    protected ?int $id = null;

    /**
     * Construtor da classe Imovel
     * 
     * @param string $endereco Nome/endereço do imóvel
     * @param string $tipo Tipo do imóvel
     * @param string $acomodacoes Acomodações do imóvel
     * @param bool $disponivel Status de disponibilidade
     * @param int|null $id ID no banco de dados (opcional)
     */
    public function __construct(string $endereco, string $tipo, string $acomodacoes, bool $disponivel = true, ?int $id = null) {
        $this->tipo = $tipo;
        $this->endereco = $endereco;
        $this->acomodacoes = $acomodacoes;
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
     * Verifica se o imóvel está disponível para aluguel
     * 
     * @return bool Status de disponibilidade
     */
    public function isDisponivel(): bool {
        return $this->disponivel;
    }

    /**
     * Obtém o endereço do imóvel
     * 
     * @return string Endereço do imóvel
     */
    public function getEndereco(): string {
        return $this->endereco;
    }

    /**
     * Obtém as acomodações do imóvel
     * 
     * @return string Acomodações do imóvel
     */
    public function getAcomodacoes(): string {
        return $this->acomodacoes;
    }

    /**
     * Obtém o tipo do imóvel
     * 
     * @return string Tipo do imóvel
     */
    public function getTipo(): string {
        return $this->tipo;
    }

    /**
     * Obtém o ID do imóvel no banco de dados
     * 
     * @return int|null ID do imóvel
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Define o status de disponibilidade do imóvel
     * 
     * @param bool $disponivel Status de disponibilidade
     */
    public function setDisponivel(bool $disponivel): void {
        $this->disponivel = $disponivel;
    }

    /**
     * Define o ID do imóvel (usado ao recuperar do banco)
     * 
     * @param int $id ID do imóvel no banco
     */
    public function setId(int $id): void {
        $this->id = $id;
    }
}