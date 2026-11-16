# TaskList

## Sobre o projeto

O TaskList é um sistema de gerenciamento de tarefas desenvolvido em PHP, utilizando MySQL para armazenar os dados. O objetivo do projeto é permitir que o usuário organize suas atividades, acompanhe prazos e controle suas tarefas pendentes e concluídas.

O sistema possui uma interface simples e intuitiva, facilitando o gerenciamento das atividades do dia a dia.

## Funcionalidades

- Cadastro de novas tarefas.
- Listagem de tarefas cadastradas.
- Definição do nível de importância (alta, média e baixa).
- Registro da data de criação.
- Definição da data de entrega.
- Edição de tarefas existentes.
- Marcação de tarefas como concluídas.
- Exclusão de tarefas.
- Separação entre tarefas pendentes e concluídas.

## Tecnologias utilizadas

- **PHP:** desenvolvimento da lógica do sistema.
- **MySQL:** armazenamento dos dados.
- **PDO:** conexão e comunicação com o banco de dados.
- **HTML:** estrutura das páginas.
- **CSS:** estilização e organização visual.
- **XAMPP:** ambiente de desenvolvimento local.

## Estrutura do projeto

```text
TaskList/
│
├── config/
│   └── Conexao.php
│
├── dao/
│   └── TarefaDAO.php
│
├── css/
│   └── style.css
│
├── banco de dados/
│   └── bd.sql
│
├── Tarefa.php
├── index.php
├── editar.php
└── README.md
```

## Organização do código

O projeto utiliza o padrão DAO (Data Access Object), responsável por separar as operações relacionadas ao banco de dados da interface do sistema.

**Tarefa.php:** contém a classe Tarefa, responsável por representar os dados e atributos de cada tarefa.

**TarefaDAO.php:** realiza as operações no banco de dados, como cadastrar, listar, buscar, atualizar, concluir e excluir tarefas.

**Conexao.php:** estabelece a conexão entre o PHP e o banco de dados MySQL utilizando PDO.

**index.php:** apresenta as tarefas cadastradas e permite realizar as principais operações do sistema.

**editar.php:** permite modificar as informações de uma tarefa já cadastrada.

## Como executar o projeto

1. Instale e abra o XAMPP.
2. Inicie os serviços Apache e MySQL.
3. Coloque a pasta TaskList dentro do diretório `htdocs`.
4. Acesse o phpMyAdmin pelo navegador através de `http://localhost/phpmyadmin`.
5. Importe o arquivo `bd.sql` para criar o banco de dados e a tabela.
6. Confira as configurações de conexão no arquivo `config/Conexao.php`.
7. Acesse o projeto pelo navegador:

```text
http://localhost/TaskList/
```

## Banco de dados

O sistema utiliza o MySQL para armazenar as informações das tarefas, permitindo que os dados continuem disponíveis mesmo depois que a página for fechada ou atualizada.

## Objetivo acadêmico

O projeto foi desenvolvido como atividade prática para aplicar conhecimentos de desenvolvimento web, programação orientada a objetos, integração com banco de dados e utilização do padrão DAO em PHP.

## Autor

Desenvolvido como projeto acadêmico do curso Técnico em Desenvolvimento de Sistemas.