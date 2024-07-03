use oficina;
select * from cliente;
select * from veiculo;
select * from ordemservico;
select * from peca;
select * from servico;
select * from mecanico;
select * from maodeobra;
select * from tiposervico;
select * from cliente_veiculo;
select * from os_servico;

desc ordemservico;

show tables;

-- listar clientes pessoa fisica
select * from Cliente where CPF;
-- listar clientes pessoa juridica
select * from Cliente where CNPJ;
-- listar clientes iniciam com a letra e
select * from Cliente where Nome like 'E%';
-- listar status das ordens de serviço
select * from ordemServico where ordemstatus;
-- listar status das ordens de serviço por status especifico
select * from ordemservico where ordemstatus = 'Aberto';
-- listar ordens de serviço com informações do tipo de serviço, peças e mao de obra
select * from ordemservico inner join tipoServico on OStipoServico =  idtiposervico;

    