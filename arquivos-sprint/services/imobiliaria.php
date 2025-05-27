<?php
namespace Services;
use Models\{imovel, Casa, Apartamento};

/**
 * Classe responsável por gerenciar as operações da locadora
 */
class imobiliaria {
    /**
     * Conexão com o banco de dados
     * @var \PDO
     */
    private \PDO $db;
    
    /**
     * Lista de veículos carregados
     * @var array
     */
    private array $imoveis= [];

    /**
     * Construtor da classe Locadora
     */
    public function __construct() {
        $this->db = getConnection();
        $this->carregarImoveis();
    }

    /**
     * Carrega os veículos do banco de dados
     */
    private function carregarImoveis(): void {
        $stmt = $this->db->query("SELECT * FROM imoveis");
        $imoveisDb = $stmt->fetchAll();
        
        $this->imoveis = []; // Limpa a lista antes de carregar
        
        foreach ($imoveisDb as $dado) {
            if ($dado['tipo'] === 'casa') {
                $imovel = new Casa(
                    $dado['modelo'], 
                    $dado['placa'], 
                    (bool)$dado['disponivel'],
                    $dado['id']
                );
            } else {
                $imovel = new Apartamento(
                    $dado['modelo'], 
                    $dado['placa'], 
                    (bool)$dado['disponivel'],
                    $dado['id']
                );
            }
            $this->imoveis[] = $imovel;
        }
    }

    /**
     * Adiciona um novo veículo à locadora
     * 
     * @param imovel $imovel Veículo a ser adicionado
     * @return bool Resultado da operação
     */
    public function adicionarimovel(imovel $imovel): bool {
        $tipo = ($imovel instanceof Casa) ? 'Casa' : 'Apartamento';
        
        try {
            $stmt = $this->db->prepare("
                INSERT INTO imoveis (tipo, modelo, placa, disponivel) 
                VALUES (?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $tipo,
                $imovel->getEndereço(),
                $imovel->getAcomodaçoes(),
                $imovel->isDisponivel() ? 1 : 0
            ]);
            
            if ($result) {
                // Define o ID gerado no objeto
                $imovel->setId($this->db->lastInsertId());
                $this->imoveis[] = $imovel;
            }
            
            return $result;
        } catch (\PDOException $e) {
            // Em caso de erro, como placa duplicada
            return false;
        }
    }

    /**
     * Remove um veículo da locadora
     * 
     * @param string $modelo Modelo do veículo
     * @param string $placa Placa do veículo
     * @return string Mensagem de resultado da operação
     */
    public function deletarimovel(string $modelo, string $placa): string {
        // Primeiro encontra o veículo na memória para ter o ID
        $id = null;
        foreach ($this->imoveis as $key => $imovel) {
            if ($imovel->getModelo() === $modelo && $imovel->getPlaca() === $placa) {
                $id = $imovel->getId();
                unset($this->imoveis[$key]);
                $this->imoveis = array_values($this->imoveis); // Reindexar array
                break;
            }
        }
        
        if ($id !== null) {
            $stmt = $this->db->prepare("DELETE FROM imoveis WHERE id = ?");
            if ($stmt->execute([$id])) {
                return "Veículo '{$modelo}' removido com sucesso!";
            }
            return "Erro ao remover veículo do banco de dados.";
        }
        
        return "Veículo não encontrado.";
    }

    /**
     * Aluga um veículo por um número específico de dias
     * 
     * @param string $modelo Modelo do veículo
     * @param int $dias Quantidade de dias do aluguel
     * @return string Mensagem de resultado da operação
     */
    public function alugarimovel(string $modelo, int $dias = 1): string {
        foreach ($this->imoveis as $imovel) {
            if ($imovel->getModelo() === $modelo && $imovel->isDisponivel()) {
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
        return "Veículo não disponível.";
    }

    /**
     * Devolve um veículo alugado
     * 
     * @param string $modelo Modelo do veículo
     * @return string Mensagem de resultado da operação
     */
    public function devolverimovel(string $modelo): string {
        foreach ($this->imoveis as $imovel) {
            if ($imovel->getModelo() === $modelo && !$imovel->isDisponivel()) {
                $mensagem = $imovel->devolver();
                
                // Atualiza no banco de dados
                $stmt = $this->db->prepare("
                    UPDATE imoveis SET disponivel = 1 WHERE id = ?
                ");
                $stmt->execute([$imovel->getId()]);
                
                return $mensagem;
            }
        }
        return "Veículo não encontrado ou já está disponível.";
    }

    /**
     * Retorna a lista de todos os veículos
     * 
     * @return array Lista de veículos
     */
    public function listarimoveis(): array {
        return $this->imoveis;
    }

    /**
     * Calcula uma previsão de valor do aluguel
     * 
     * @param string $tipo Tipo do veículo (casa ou apartamento)
     * @param int $dias Quantidade de dias
     * @return float Valor previsto do aluguel
     */
    public function calcularPrevisaoAluguel(string $tipo, int $dias): float {
        if ($tipo === 'casa') {
            return (new casa('', ''))->calcularAluguel($dias);
        }
        return (new apartamento('', ''))->calcularAluguel($dias);
    }
}