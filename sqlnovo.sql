CREATE DATABASE IF NOT EXISTS `emsql1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `emsql1`;

-- --------------------------------------------------------
-- Tabela de contas (usuários)
CREATE TABLE `contas` (
  `id_conta` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `sobrenome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `contato` varchar(11) NOT NULL,
  `data_nasc` date NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `genero` varchar(20) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_conta`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tabela de cursos
CREATE TABLE `cursos` (
  `id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `nome_curso` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `duracao` int(11) NOT NULL COMMENT 'em horas',
  `imagem` varchar(255) NOT NULL,
  `link_video` varchar(255) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tabela de relação usuário-cursos
CREATE TABLE `usuario_cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_conta` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `data_inscricao` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('EM ANDAMENTO','CONCLUÍDO') NOT NULL DEFAULT 'EM ANDAMENTO',
  `ultimo_acesso` timestamp NULL DEFAULT NULL,
  `progresso` int(11) DEFAULT 0 COMMENT 'Percentual de conclusão',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_inscricao` (`id_conta`,`id_curso`),
  KEY `id_curso` (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tabela de pedidos (existente)
CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_conta` int(11) NOT NULL,
  `data_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_entrega` timestamp NULL DEFAULT NULL,
  `endereco` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_conta` (`id_conta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tabela de detalhes de pedidos (existente)
CREATE TABLE `detal_pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pedido` (`id_pedido`),
  KEY `id_produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tabela de produtos (existente)
CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `produto_nome` varchar(100) NOT NULL,
  `produto_desc` text NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `img` varchar(255) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tabela de avaliações (existente)
CREATE TABLE `reviews` (
  `id_review` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `texto_avalia` text DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `data_avaliacao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_review`),
  KEY `id_pedido` (`id_pedido`),
  KEY `id_produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `categorias_cursos` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome_categoria` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Alterar tabela cursos para usar chave estrangeira
ALTER TABLE `cursos` 
ADD COLUMN `id_categoria` int(11) DEFAULT NULL,
ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_cursos` (`id_categoria`);

-- --------------------------------------------------------
-- Chaves estrangeiras
ALTER TABLE `usuario_cursos`
  ADD CONSTRAINT `usuario_cursos_ibfk_1` FOREIGN KEY (`id_conta`) REFERENCES `contas` (`id_conta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_cursos_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_conta`) REFERENCES `contas` (`id_conta`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `detal_pedidos`
  ADD CONSTRAINT `detal_pedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detal_pedidos_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

  -- Inserir alguns cursos de exemplo
INSERT INTO `cursos` (`nome_curso`, `descricao`, `duracao`, `imagem`, `link_video`, `categoria`) VALUES
('Curso Básico de Direção', 'Aprenda os fundamentos da direção com nosso curso completo para iniciantes.', 20, 'curso1.jpg', 'https://www.youtube.com/watch?v=ABCD1234', 'Iniciante'),
('Direção Defensiva', 'Técnicas avançadas para dirigir com segurança em qualquer situação.', 15, 'curso2.jpg', 'https://www.youtube.com/watch?v=EFGH5678', 'Avançado'),
('Reciclagem para Condutores', 'Para quem já tem habilitação mas está há muito tempo sem dirigir.', 10, 'curso3.jpg', 'https://www.youtube.com/watch?v=IJKL9012', 'Reciclagem'),
('Direção Noturna', 'Aprenda técnicas específicas para dirigir com segurança à noite.', 8, 'curso4.jpg', 'https://www.youtube.com/watch?v=MNOP3456', 'Especialização');

-- Inserir um usuário admin (senha: admin123)
INSERT INTO `contas` (`nome`, `sobrenome`, `email`, `cpf`, `contato`, `data_nasc`, `username`, `password`, `genero`) VALUES
('Admin', 'Sistema', 'admin@driveup.com', '12345678901', '21999999999', '1990-01-01', 'admin1', 'admin123', 'Masculino');

UPDATE cursos SET imagem = 'curso1.png' WHERE id_curso =1 ;
UPDATE cursos SET imagem = 'curso2.png' WHERE id_curso =2 ;
UPDATE cursos SET imagem = 'curso3.png' WHERE id_curso =3 ;
UPDATE cursos SET imagem = 'curso4.png' WHERE id_curso =4 ;
ALTER TABLE cursos ADD COLUMN nivel VARCHAR(50) DEFAULT 'Todos os níveis';


drop database emsql1;

drop table contas;

