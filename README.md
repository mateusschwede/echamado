# EChamado
Software gestor de chamado suporte técnico

## Descrição
O EChamado é um software gestor de chamados eletrônicos para auxiliar o suporte tecnico com suas rotinas. Em sua composição, encontra-se um administrador, responsável por gerenciar os cadastros no sistema e verificar relatórios detalhados, os tecnicos, responsáveis por analisar e finalizar os chamados recebidos, e os clientes, que podem realizar chamados, verificar o andamento dos mesmos e consultar seu histórico.

> **Instalação:** Baixe os arquivos do Github no *htdocs* do seu Xampp executando. 1º execute o arquivo .sql no *Phpmyadmin*, em seguida podes acessar o sistema, no *localhost* do seu Xampp Php, acessando o modo administrador(login:adm,senha:adm) para adicionar máquinas,tecnicos e clientes, nessa respectiva ordem.

## Usuários/Funcionalidades
- **Admin**
  - Gerenciamento de clientes (addCliente,edCliente,verClientes,ativar/inativarCliente)
  - Gerenciamento de máquinas (addMaquina,edMaquina,verMaquinas,ativar/inativarMaquina)
  - Gerenciamento de tecnicos (addTecnico,edTecnico,verTecnicos,ativar/inativarTecnico)
  - Relatório chamados por máquina
  - Relatório chamados por cliente
  - Relatório chamados por tecnico
  - Relatório chamados por data

> **Chamados nos relatórios:** Chamados pendentes/analise/resolvidos classificados por tipo(urgente,moderado,leve) ordenados em ordem cronológica decrescente

- **Tecnico**
  - Chamados pendentes
  - Analisar chamado
  - Finalizar meu chamado
  - Relatório 'meus chamados'
- **Cliente**
  - Adicionar chamado
  - Editar chamado pendente/analise
  - Relatório 'meus chamados'

### Admin
- login('admin')
- senha('admin')

### Maquina
- ip
- nome
- ativo

### Cliente
- id
- nome
- senha
- ativo
- ipMaquina

### Tecnico
- id
- nome
- senha
- ativo

### Chamado
- id
- dthrCadastro
- descricao
- tipo (leve,moderado,preciso,urgente)
- situacao (pendente,analise,finalizado)
- ipMaquina
- nomeCliente
- idTecnico (qndo finalizado)
- dthrAnalise (qndo tecnico analisa)
- dthrFinalizado

## Tecnologias
- Php7.4(Pdo)
- Mysql(MariaDB10)
- Bootstrap4.5

## Licença
- MIT *(Livre para qualquer uso, sujeito à responsabilidades)*

## Contato
- **Email:** mateus1908.schwede@gmail.com
- **Github:** mateusschwede
- **Site:** mateusschwede.github.io

> **Author:** Mateus Schwede, 2020
