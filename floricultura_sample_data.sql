-- Dados de exemplo para desenvolvimento
INSERT INTO `produtos` (`nome`, `descricao`, `preco`, `imagem`) VALUES
('Rosa Vermelha', 'Buquê com 12 rosas vermelhas', 89.90, 'rosas-vermelhas.jpg'),
('Cacto Decorativo', 'Cacto pequeno para escritório', 35.50, 'cacto-decorativo.jpg');

INSERT INTO `usuarios` (`nome`, `email`, `senha`, `tipo`) VALUES
('Usuário Teste', 'teste@email.com', '$2y$10$hashedpassword', 'usuario'),
('Admin Teste', 'admin@email.com', '$2y$10$hashedadminpass', 'admin');