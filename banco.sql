CREATE DATABASE echamado CHARSET=utf8;
USE echamado;

CREATE TABLE maquina (
    ip VARCHAR(30) PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT 1
) CHARSET=utf8;

CREATE TABLE cliente (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    senha VARCHAR(5) NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT 1,
    ipMaquina VARCHAR(30) NOT NULL
) CHARSET=utf8;

CREATE TABLE tecnico (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    senha VARCHAR(5) NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT 1
) CHARSET=utf8;

CREATE TABLE chamado (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    dthrCadastro DATETIME NOT NULL DEFAULT now(),
    descricao VARCHAR(500) NOT NULL,
    tipo VARCHAR(10) NOT NULL,
    situacao VARCHAR(10) NOT NULL DEFAULT "pendente",
    ipMaquina VARCHAR(30) NOT NULL,
    idCliente INTEGER NOT NULL,
    idTecnico INTEGER,
    dthrAnalise DATETIME,
    dthrFinalizado DATETIME
) CHARSET=utf8;
/*Tipos: leve,moderado,preciso,urgente
Situações: pendente,analise,finalizado*/

INSERT INTO maquina(ip,nome,ativo) VALUES ("232-333-456","notebook lenovo x10",1),("233-333-455","notebook asus5",0s);
INSERT INTO cliente(nome,senha,ipMaquina,ativo) VALUES ("fulano","333","232-333-456",1),("fulanoInativo","444","233-333-455",0);
INSERT INTO tecnico(nome,senha) VALUES ("siclano","11");
INSERT INTO chamado(descricao,tipo,ipMaquina,idCliente,idTecnico) VALUES ("carregador estragou, será necessária a troca por um novo carregador, juntamente com o cabo","moderado","232-333-456",1,1);