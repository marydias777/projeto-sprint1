-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS imobiliaria
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Seleciona o banco de dados
USE imobiliaria;

-- Criação da tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    perfil VARCHAR(20) NOT NULL
) ENGINE=InnoDB;

-- Criação da tabela de imóveis
CREATE TABLE IF NOT EXISTS imoveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(20) NOT NULL,
    endereco VARCHAR(200) NOT NULL,
    acomodacoes VARCHAR(50) NOT NULL UNIQUE,
    disponivel BOOLEAN NOT NULL DEFAULT TRUE
) ENGINE=InnoDB;

-- Insere usuários padrão
-- Nota: As senhas estão em formato hash, geradas com password_hash()
-- admin123 e user123 são as senhas em texto puro
INSERT INTO usuarios (username, password, perfil) VALUES 
    ('admin', '$2y$10$4gAzJ/Kq4NFc.K3nXi.l0OQsRHxqZJ8/Z2MtMrjorJX66IvPZOOym', 'admin'),
    ('usuario', '$2y$10$reDVMnCMBItvD.Ru13M/Heqn0K5C3t8cL7.jxvAfLk1xEFXbqB9HG', 'usuario');

-- Insere imóveis padrão para demonstração
INSERT INTO imoveis (tipo, endereco, acomodacoes, disponivel) VALUES 
    ('Casa', 'Rua das Flores, 123 - Centro, São Paulo - SP', '4 pessoas', FALSE),
    ('Apartamento', 'Av. Paulista, 1000 - Bela Vista, São Paulo - SP', '2 pessoas', TRUE),
    ('Casa', 'Rua da Paz, 456 - Vila Madalena, São Paulo - SP', '6 pessoas', TRUE),
    ('Apartamento', 'Rua Augusta, 789 - Consolação, São Paulo - SP', '3 pessoas', TRUE);