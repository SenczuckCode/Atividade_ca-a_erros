CREATE DATABASE if not exists Sistema_loja_erros_2;

USE Sistema_loja_erros_2;

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    estoque INT NOT NULL,
    categoria VARCHAR(50) NOT NULL  
);