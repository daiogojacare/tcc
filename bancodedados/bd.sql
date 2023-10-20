DROP DATABASE bdcantina;

CREATE DATABASE bdcantina;

USE bdcantina;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivel_acesso ENUM('adm', 'usuario') NOT NULL
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL, 
    categoria VARCHAR(100) NOT NULL
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    tamanho VARCHAR(255) NOT NULL,
    comidas TEXT,
    data_hora_pedido DATETIME NOT NULL
);

INSERT INTO usuarios (nome, email, senha, nivel_acesso)
VALUES ('cantina', 'admin@gmail.com', '123123', 'adm');
