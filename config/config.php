<?php
// Arquivo de configuração com constantes do sistema

// Configurações do Banco de Dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');         // Altere para seu usuário do MySQL
define('DB_PASS', 'Senai@118');    // Altere para sua senha do MySQL
define('DB_NAME', 'imobiliaria');  // Nome do banco de dados

// Constantes de diárias
define('DIARIA_CASA', 100.00);
define('DIARIA_APARTAMENTO', 50.00);

// Definir senhas padrão para facilitar debug - use apenas em desenvolvimento
define('ADMIN_PASSWORD', 'admin123');
define('USER_PASSWORD', 'user123');

/**
 * Função para criar a conexão com o banco de dados
 * @return PDO Objeto de conexão PDO
 */
function getConnection() {
    try {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        // Em produção, evite mostrar detalhes do erro
        die('Erro de conexão com o banco de dados: ' . $e->getMessage());
    }
}

/**
 * Função para inicializar o banco de dados se não existir
 */
function initDatabase() {
    try {
        // Primeiro cria o banco se não existir
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        
        // Cria o banco de dados se não existir
        $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE " . DB_NAME);
        
        // Cria a tabela de usuários se não existir
        $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            perfil VARCHAR(20) NOT NULL
        ) ENGINE=InnoDB");
        
        // Cria a tabela de imóveis se não existir (corrigida)
        $pdo->exec("CREATE TABLE IF NOT EXISTS imoveis (
            id INT AUTO_INCREMENT PRIMARY KEY,
            tipo VARCHAR(20) NOT NULL,
            endereco VARCHAR(200) NOT NULL,
            acomodacoes VARCHAR(50) NOT NULL,
            disponivel BOOLEAN NOT NULL DEFAULT TRUE
        ) ENGINE=InnoDB");
        
        // Verifica se existem usuários cadastrados
        $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
        $count = $stmt->fetchColumn();
        
        // Se não existirem usuários, insere os padrões
        if ($count == 0) {
            // Pré-cria os hashes para garantir consistência
            $admin_hash = password_hash(ADMIN_PASSWORD, PASSWORD_DEFAULT);
            $user_hash = password_hash(USER_PASSWORD, PASSWORD_DEFAULT);
            
            // Log para debug - remova em produção
            error_log("Criando usuários padrão: admin/usuario");
            
            $pdo->prepare("INSERT INTO usuarios (username, password, perfil) VALUES 
                (?, ?, ?), (?, ?, ?)")
                ->execute([
                    'admin', $admin_hash, 'admin',
                    'usuario', $user_hash, 'usuario'
                ]);
        }
        
        // Verifica se existem imóveis cadastrados
        $stmt = $pdo->query("SELECT COUNT(*) FROM imoveis");
        $count = $stmt->fetchColumn();
        
        // Se não existirem imóveis, insere alguns exemplos
        if ($count == 0) {
            $pdo->exec("INSERT INTO imoveis (tipo, endereco, acomodacoes, disponivel) VALUES 
                ('Casa', 'Rua das Flores, 123 - Centro, São Paulo - SP', '4 pessoas', FALSE),
                ('Apartamento', 'Av. Paulista, 1000 - Bela Vista, São Paulo - SP', '2 pessoas', TRUE),
                ('Casa', 'Rua da Paz, 456 - Vila Madalena, São Paulo - SP', '6 pessoas', TRUE),
                ('Apartamento', 'Rua Augusta, 789 - Consolação, São Paulo - SP', '3 pessoas', TRUE)");
        }
        
    } catch (PDOException $e) {
        die('Erro ao inicializar o banco de dados: ' . $e->getMessage());
    }
}

// Inicializa o banco de dados quando o arquivo de configuração é carregado
initDatabase();