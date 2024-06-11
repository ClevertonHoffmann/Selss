create database dbseels;

USE sdbseels;

CREATE TABLE tbusuarios (
  seq int NOT NULL AUTO_INCREMENT,
  email varchar(100) NOT NULL,
  senha varchar(255) NOT NULL,
  PRIMARY KEY (seq)
)

select * from tbusuarios;

CREATE TABLE tbdadosusuarios (
  seq int NOT NULL AUTO_INCREMENT,
  defReg TEXT NOT NULL,
  palavrasReservadas TEXT NOT NULL,
  tabelaAnaliseLexica LONGTEXT NOT NULL,
  estTransicaoExpToken LONGTEXT NOT NULL,
  modalAutomato LONGTEXT NOT NULL,
  modalTabelaAnaliseLexica LONGTEXT NOT NULL,
  codigoParaAnalise TEXT NOT NULL,
  resultadoAnaliseLexica LONGTEXT NOT NULL,
  PRIMARY KEY (seq)
)

select * from tbdadosusuarios;

CREATE TABLE tbdatasistema (
  seq int NOT NULL AUTO_INCREMENT,
  cabecalho TEXT NOT NULL,
  caracteresinvalidos TEXT NOT NULL,
  caracteresvalidos TEXT NOT NULL,
  instrucoesdeuso TEXT NOT NULL,
  sugestoes LONGTEXT NOT NULL,
  PRIMARY KEY (seq)
)

select * from tbdatasistema;