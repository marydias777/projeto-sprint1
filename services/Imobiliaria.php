<?php
namespace Services;
use Models\{Imovel, Casa, Apartamento};

/**
 * Classe responsável por gerenciar as operações da imobiliária
 */
class Imobiliaria {
    /**
     * Conexão com o banco de dados
     * @var \PDO
     */
    private \PDO $db;
    
    /**
     * Lista de imóveis carregados
     * @var array
     */
    private array $imoveis = [];

    /**
     * Construtor da classe Imobiliaria
     */
    public function __construct() {
        $this->db = getConnection();
        $this->carregarImoveis();
    }

    /**
     * Carrega os imóveis do banco de dados
     */
    private function carregarImoveis(): void {
        $stmt = $this->db->query("SELECT * FROM imoveis");
        $imoveisDb = $stmt->fetchAll();
        
        $this->imoveis = []; // Limpa a lista antes de carregar
        
        foreach ($imoveisDb as $dado) {
            if ($dado['tipo'] === 'Casa') {
                $imovel = new Casa(
                    $dado['endereco'], 
                    $dado['tipo'],
                    $dado['acomodacoes'], 
                    (bool)$dado['disponivel'],
                    $dado['id']
                );
            } else {
                $imovel = new Apartamento(
                    $dado['endereco'], 
                    $dado['tipo'],
                    $dado['acomodacoes'], 
                    (bool)$dado['disponivel'],
                    $dado['id']
                );
            }
            $this->imoveis[] = $imovel;
        }
    }

    /**
     * Adiciona um novo imóvel à imobiliária
     * 
     * @param Imovel $imovel Imóvel a ser adicionado
     * @return bool Resultado da operação
     */
    public function adicionarImovel(Imovel $imovel): bool {
        $tipo = ($imovel instanceof Casa) ? 'Casa' : 'Apartamento';
        
        try {
            $stmt = $this->db->prepare("
                INSERT INTO imoveis (tipo, endereco, acomodacoes, disponivel) 
                VALUES (?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $tipo,
                $imovel->getEndereco(),
                $imovel->getAcomodacoes(),
                $imovel->isDisponivel() ? 1 : 0
            ]);
            
            if ($result) {
                // Define o ID gerado no objeto
                $imovel->setId($this->db->lastInsertId());
                $this->imoveis[] = $imovel;
            }
            
            return $result;
        } catch (\PDOException $e) {
            // Em caso de erro, como dados duplicados
            return false;
        }
    }

    /**
     * Remove um imóvel da imobiliária
     * 
     * @param string $endereco Endereço do imóvel
     * @return string Mensagem de resultado da operação
     */
    public function deletarImovel(string $endereco): string {
        // Primeiro encontra o imóvel na memória para ter o ID
        $id = null;
        foreach ($this->imoveis as $key => $imovel) {
            if ($imovel->getEndereco() === $endereco) {
                $id = $imovel->getId();
                unset($this->imoveis[$key]);
                $this->imoveis = array_values($this->imoveis); // Reindexar array
                break;
            }
        }
        
        if ($id !== null) {
            $stmt = $this->db->prepare("DELETE FROM imoveis WHERE id = ?");
            if ($stmt->execute([$id])) {
                return "Imóvel '{$endereco}' removido com sucesso!";
            }
            return "Erro ao remover imóvel do banco de dados.";
        }
        
        return "Imóvel não encontrado.";
    }

    /**
     * Aluga um imóvel por um número específico de dias
     * 
     * @param string $endereco Endereço do imóvel
     * @param int $dias Quantidade de dias do aluguel
     * @return string Mensagem de resultado da operação
     */
    public function alugarImovel(string $endereco, int $dias = 1): string {
        foreach ($this->imoveis as $imovel) {
            if ($imovel->getEndereco() === $endereco && $imovel->isDisponivel()) {
                $valorAluguel = $imovel->calcularAluguel($dias);
                $mensagem = $imovel->alugar();
                
                // Atualiza no banco de dados
                $stmt = $this->db->prepare("
                    UPDATE imoveis SET disponivel = 0 WHERE id = ?
                ");
                $stmt->execute([$imovel->getId()]);
                
                return $mensagem . " Valor do aluguel: R$ " . number_format($valorAluguel, 2, ',', '.');
            }
        }
        return "Imóvel não disponível.";
    }

    /**
     * Devolve um imóvel alugado
     * 
     * @param string $endereco Endereço do imóvel
     * @return string Mensagem de resultado da operação
     */
    public function devolverImovel(string $endereco): string {
        foreach ($this->imoveis as $imovel) {
            if ($imovel->getEndereco() === $endereco && !$imovel->isDisponivel()) {
                $mensagem = $imovel->devolver();
                
                // Atualiza no banco de dados
                $stmt = $this->db->prepare("
                    UPDATE imoveis SET disponivel = 1 WHERE id = ?
                ");
                $stmt->execute([$imovel->getId()]);
                
                return $mensagem;
            }
        }
        return "Imóvel não encontrado ou já está disponível.";
    }

    /**
     * Retorna a lista de todos os imóveis
     * 
     * @return array Lista de imóveis
     */
    public function listarImoveis(): array {
        return $this->imoveis;
    }

    /**
     * Calcula uma previsão de valor do aluguel
     * 
     * @param string $tipo Tipo do imóvel (Casa ou Apartamento)
     * @param int $dias Quantidade de dias
     * @return float Valor previsto do aluguel
     */
    public function calcularPrevisaoAluguel(string $tipo, int $dias): float {
        if ($tipo === 'Casa') {
            return (new Casa('', '', ''))->calcularAluguel($dias);
        }
        return (new Apartamento('', '', ''))->calcularAluguel($dias);
    }
}