
-- tabela criada
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    perfil VARCHAR(20) NOT NULL
) ENGINE=InnoDB;


-- inserindo valores na tabela
INSERT INTO usuarios (username, password, perfil) VALUES 
    ('admin', '$2y$10$4gAzJ/Kq4NFc.K3nXi.l0OQsRHxqZJ8/Z2MtMrjorJX66IvPZOOym', 'admin'),
    ('usuario', '$2y$10$reDVMnCMBItvD.Ru13M/Heqn0K5C3t8cL7.jxvAfLk1xEFXbqB9HG', 'usuario');
    
-- admin123 e user123 são as senhas em texto puro