create database oficina;
use oficina;

CREATE TABLE cliente (
  idCliente INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Nome VARCHAR(30),
  Endereco VARCHAR(30),
  CPF CHAR(9),
  CNPJ CHAR(15),
  Email VARCHAR(30),
  Fone VARCHAR(20),
  constraint unique_cpf_client unique(CPF),
  constraint unique_cnpj_client unique(CNPJ)
  );
  
  desc cliente;
  drop table cliente;
  
  alter table CLIENTE modify Nome VARCHAR(30);
  select * from cliente;
  select * from veiculo;
  drop table veiculo;
  
  CREATE TABLE VEICULO (
	idVeiculo INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    placa varchar(15),
    constraint unique_placa_veiculo unique(placa)
    );
    
    select * from veiculo;
    alter table mecanico modify descricao VARCHAR(50);
    
    CREATE TABLE MECANICO (
  idMecanico INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Nome VARCHAR(30),
  Endereco VARCHAR(30),
  Email VARCHAR(30),
  Fone VARCHAR(20),
  Descricao varchar(20),
  Especialidade varchar(20)
  );
  
  select * from mecanico;
  
  create table peca(
    idPeca INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     Nome VARCHAR(45),
     valor float,
     constraint unique_nome_peca unique (Nome)
  );
  
  select * from peca;
  drop table maodeobra;
  
  create table MAODEOBRA (
	idMaodeobra INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    horas float,
    custo float
  );
  
  select * from maodeobra;
  
   create table SERVICO (
	idServico INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    descricao varchar(255),
    status enum("Aberto","Em Processamento","Cancelado","Concluido") default "Aberto"
    );
    
    desc servico;
    drop table servico;
    select * from servico;
    drop table cliente_veiculo;
    desc cliente_veiculo;
    show tables ;
    
    select * from cliente_veiculo;
    
    create table cliente_veiculo(
		idClienteVeiculo int,
        idVeiculoCliente int,
        primary key (idClienteVeiculo, idVeiculoCliente),
        constraint fk_cliente_veiculo foreign key (idClienteVeiculo) references cliente(idCliente),
        constraint fk_veiculo_cliente foreign key (idVeiculoCliente) references veiculo(idVeiculo)
    );
    
    select * from OrdemServico;
    
    create table OrdemServico(
		idOrdemServico INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        descricao varchar(255),
        dataEmissao date,
        dataEntrega date,
        valorTotal float,
        ordemStatus ENUM("Aberto", "Processamento", "Cancelado", "Concluido"),
        OStipoServico int not null,
        OSpeca int not null,
        OSmaodeobra int not null,
        constraint fk_ordemservico_peca foreign key (OSpeca) references peca(idpeca),
        constraint fk_ordemservico_maodeobra foreign key (OSmaodeobra) references maodeobra(idMaodeobra)
        on update cascade
    );
    
    select * from OS_servico;
    
      create table OS_servico(
		idOSservico int,
        idOSOrdem int,
        primary key (idOSservico, idOSOrdem),
        constraint fk_OS_servico foreign key (idOSservico) references servico(idServico),
        constraint fk_OS_oredem foreign key (idOSOrdem) references OrdemServico(idOrdemServico)
    );
    
    
 
    select * from tiposervico;
    
       create table TipoServico(
		idTipoServico INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		conserto varchar(255),
        revisao varchar(255),
        TSmecanico int,
        constraint fk_TipoServico_mecanico foreign key (TSmecanico) references mecanico(idMecanico)
    );
    
      alter table OrdemServico add constraint fk_OrdemServico_tipoServico foreign key (OStipoServico) references tiposervico(idTipoServico) on update cascade;
    
    
    
    
  