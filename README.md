# Avaliação PHP - MySQL

## Descrição do Projeto

Este projeto foi desenvolvido como parte de uma avaliação técnica para demonstrar conhecimentos em desenvolvimento web utilizando PHP, MySQL e JavaScript. O sistema é um painel administrativo que permite o gerenciamento de funcionários e empresas, incluindo operações como cadastro, edição, exclusão, listagem e geração de relatórios em PDF.

---

## Tecnologias Utilizadas

- **PHP**: Aplicação construída com PHP utilizando programação orientada a objetos.
- **Arquitetura MVC**: Separação entre Model, View e Controller para maior organização e manutenibilidade.
- **PDO (PHP Data Objects)**: Para conexão e manipulação segura do banco de dados.
- **MySQL**: Banco de dados utilizado para armazenar informações do sistema.
- **JavaScript**: Interatividade e manipulação de DOM.
- **cdnjs**: Uso de bibliotecas externas como jsPDF e jsPDF-AutoTable para geração de PDFs.
- **HTML5 e CSS3**: Criação e estilização das interfaces.
- **Git**: Controle de versão do projeto.

---

## Funcionalidades do Sistema

### **1. Gerenciamento de Funcionários**
- Cadastro de novos funcionários.
- Edição de dados de funcionários via modal.
- Exclusão de registros com confirmação via modal estilizado.
- Listagem completa com:
  - Data de cadastro.
  - Cálculo automático de bonificações:
    - Funcionários com mais de 1 ano recebem 10% de bonificação (linha destacada em azul).
    - Funcionários com mais de 5 anos recebem 20% de bonificação (linha destacada em vermelho).
- Exportação da lista de funcionários para PDF.

### **2. Gerenciamento de Empresas**
- Cadastro de empresas com validação para evitar duplicidade.
- Exibição de mensagens de sucesso ou erro ao cadastrar.

### **3. Exportação de Dados**
- Geração de relatórios em PDF usando **jsPDF** e **jsPDF-AutoTable** via CDN.

### **4. Interface Amigável**
- Feedback claro e dinâmico com uso de modais.
- Botões de ação estilizados e intuitivos.

---

## Estrutura do Projeto

O projeto segue a estrutura MVC (Model-View-Controller).
---
## Requisitos do Sistema

Antes de executar o projeto, certifique-se de que as seguintes dependências estejam instaladas:

- **PHP**: Versão 7.4 ou superior.
- **Servidor Apache**: Exemplo: XAMPP.
- **MySQL**: Banco de dados para armazenar as informações.

---

## Configuração do Banco de Dados

1. Crie um banco de dados chamado `controle_funcionarios`.
2. Execute o script SQL disponível no arquivo `db_script.sql` para criar as tabelas e inserir os dados iniciais:
   ```bash
   mysql -u [usuário] -p controle_funcionarios < db_script.sql

---

## Como Executar o Projeto

1. git clone https://github.com/azv1ctor/projeto_avaliacao_php
2. Configure o arquivo Database.php com as credenciais do banco de dados:
- define('DB_HOST', 'localhost');
- define('DB_NAME', 'controle_funcionarios');
- define('DB_USER', 'seu_usuario');
- define('DB_PASS', 'sua_senha');
3. Inicie o servidor Apache e acesse o projeto no navegador:
- http://localhost/projeto/public

---

## Validações e Segurança

1. Todas as interações com o banco de dados utilizam prepared statements, prevenindo ataques de SQL Injection.
2. O sistema realiza validações no backend e exibe mensagens claras ao usuário em casos de sucesso ou erro.

## Observações Finais

1. O projeto foi desenvolvido com foco em atender todos os requisitos descritos no documento de avaliação.

## Contato

1. E-mail: joaovictoralvesazevedo@gmail.com
2. LinkedIn: https://www.linkedin.com/in/jv-alves-dev/

