CREATE DATABASE controle_funcionarios;

USE controle_funcionarios;

CREATE TABLE tbl_usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE tbl_empresa (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(40) NOT NULL
);

CREATE TABLE tbl_funcionario (
    id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    rg VARCHAR(20),
    email VARCHAR(30) NOT NULL,
    id_empresa INT,
    data_cadastro DATE,
    salario DOUBLE(10,2),
    bonificacao DOUBLE(10,2),
    FOREIGN KEY (id_empresa) REFERENCES tbl_empresa(id_empresa)
);

INSERT INTO tbl_usuario (login, senha)
VALUES ('teste@gmail.com.br', MD5('1234'));

-- teste de inserção para funcionário com mais de 5 anos
INSERT INTO tbl_funcionario (nome, cpf, rg, email, id_empresa, data_cadastro, salario, bonificacao) 
VALUES ('Funcionário Antigo', '12345678901', '12345678', 'antigo@email.com', 1, '2018-01-01', 3000.00, 0.00);