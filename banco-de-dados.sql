
CREATE DATABASE IF NOT EXISTS floricultura;
USE floricultura;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'usuario') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS produtos (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios (nome, email, senha, tipo) 
VALUES ('Administrador', 'admin@floricultura.com', '$2y$10$8tGmGzgvGmQQLdv9X.Gg2.XGS1Zk9GQbO0YQEHlVyXxSQ1IbQJnHa', 'admin');

INSERT INTO produtos (nome, descricao, preco, imagem) VALUES 
('Buquê de Rosas Vermelhas', 'Lindo buquê com 12 rosas vermelhas, símbolo de amor e paixão. Perfeito para presentear em ocasiões especiais.', 89.90, NULL),
('Orquídea Phalaenopsis', 'Elegante orquídea phalaenopsis em vaso decorativo. Planta de fácil manutenção e longa duração.', 129.90, NULL),
('Arranjo de Flores do Campo', 'Arranjo rústico com flores do campo variadas em tons de amarelo, branco e verde. Traz alegria e frescor para qualquer ambiente.', 75.50, NULL),
('Cesta de Girassóis', 'Cesta com girassóis, símbolo de felicidade e vitalidade. Acompanha chocolates finos e cartão personalizado.', 110.00, NULL),
('Terrário de Suculentas', 'Terrário de vidro com composição de suculentas variadas. Decoração moderna e de baixa manutenção.', 95.00, NULL),
('Buquê de Lírios', 'Buquê elegante com lírios brancos e folhagens. Perfeito para decoração ou presente.', 120.00, NULL);

