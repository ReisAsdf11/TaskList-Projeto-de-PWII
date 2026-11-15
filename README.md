<div align="center">
# ✅ TaskList
 
**Uma lista de tarefas simples, bonita e funcional, feita em PHP + MySQL.**
 
![PHP](https://img.shields.io/badge/PHP-8%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
 
*Projeto desenvolvido para a disciplina de **PWII** (Programação Web II).*
 
</div>

 
##  Preview
 
 <img width="1860" height="902" alt="Tasklistpreview" src="https://github.com/user-attachments/assets/e2c7d8c4-2bc3-4be6-9839-387539f0f5d7" />
 
---
 
##  Sobre o projeto
 
A **TaskList** é uma aplicação web para organizar tarefas do dia a dia. Cada tarefa tem um título, um nível de importância e uma data de entrega, e a lista separa automaticamente o que ainda está **pendente** do que já foi **concluído**.
 
O projeto começou só adicionando tarefas e foi crescendo aos poucos: hoje dá para editar, excluir e concluir tarefas com uma caixinha de seleção animada.
 
---
 
##  Funcionalidades
 
-  **Adicionar tarefas** com título, importância e data de entrega
-  **Três níveis de importância:** Alta, Média e Baixa, cada um com sua etiqueta (badge)
-  **Data de criação automática**, preenchida com o dia atual
-  **Concluir tarefa** marcando a caixinha *"Concluir"*, com animação de saída
-  **Lista de concluídas**, separada das pendentes e com visual diferenciado
-  **Editar tarefa** (título, importância e data de entrega)
-  **Excluir tarefa**
-  **Contador de tarefas pendentes** no topo da página
-  **Memória da última importância usada:** um *cookie* guarda a última escolha por 30 dias e já deixa o formulário preenchido
-  **Ordenação inteligente:** pendentes primeiro, e as de entrega mais próxima no topo
-  **Tema escuro** e layout responsivo
---
 
## 🛠️ Tecnologias utilizadas
 
| Tecnologia | Para que foi usada |
|---|---|
| **PHP** (orientado a objetos) | Lógica da aplicação e regras de negócio |
| **MySQL** | Armazenamento das tarefas |
| **PDO** | Conexão e consultas ao banco de forma segura |
| **HTML5** | Estrutura das páginas |
| **CSS3** | Visual, tema escuro, animações e a caixinha personalizada |
| **JavaScript** | Pequena animação ao concluir uma tarefa |
 
---
 
## 🗂️ Estrutura do projeto
 
```
TaskList/
├── banco de dados/
│   └── bd.sql              # Script de criação do banco e da tabela
├── config/
│   └── Conexao.php         # Conexão com o MySQL (PDO)
├── css/
│   └── style.css           # Estilos da aplicação
├── dao/
│   └── TarefaDAO.php       # Acesso ao banco (cadastrar, listar, editar, concluir, excluir)
├── Tarefa.php              # Classe modelo da tarefa
├── index.php               # Página principal (formulário + listas)
└── editar.php              # Página de edição de tarefa
```
 
---
 
## 🚀 Como rodar o projeto
 
### Pré-requisitos
 
- **PHP 8+**
- **MySQL** ou **MariaDB**
- Um servidor local, como **XAMPP**, **WAMP** ou **Laragon**
### Passo a passo
 
1. **Clone o repositório**
```bash
git clone https://github.com/GalSal0967/TaskList-Projeto-de-PWII.git
```
 
2. **Mova a pasta `TaskList`** para a pasta pública do seu servidor (no XAMPP, a `htdocs`).
3. **Crie o banco de dados:** abra o phpMyAdmin, vá em *Importar* e selecione o arquivo `banco de dados/bd.sql`. Ele cria o banco `tasklist` e a tabela `tarefas`.
4. **Confira as credenciais** em `config/Conexao.php`. Por padrão:
```php
$host    = 'localhost';
$banco   = 'tasklist';
$usuario = 'root';
$senha   = '';
```
 
5. **Inicie o Apache e o MySQL** e acesse no navegador:
```
http://localhost/TaskList
```
 
---
 
## 🗄️ Banco de dados
 
Tabela `tarefas`:
 
| Coluna | Tipo | Descrição |
|---|---|---|
| `id` | INT, AUTO_INCREMENT | Identificador da tarefa |
| `titulo` | VARCHAR(255) | Nome da tarefa |
| `importancia` | ENUM('alta', 'media', 'baixa') | Nível de importância |
| `data_criacao` | DATE | Dia em que a tarefa foi criada |
| `data_entrega` | DATE | Prazo de entrega |
| `concluida` | TINYINT(1) | `0` = pendente, `1` = concluída |
| `criado_em` | TIMESTAMP | Registro automático de criação |
 
---
 
## 📚 O que aprendemos com o projeto
 
- **Programação Orientada a Objetos em PHP:** criação da classe `Tarefa` com atributos privados e *getters*, representando a tarefa como um objeto.
- **Padrão DAO (Data Access Object):** separar o acesso ao banco (`TarefaDAO`) das páginas deixa o código mais organizado e fácil de manter.
- **PDO e *prepared statements*:** consultas com parâmetros nomeados protegem a aplicação contra **SQL Injection**.
- **Segurança na saída de dados:** uso de `htmlspecialchars` para evitar **XSS** ao mostrar o que o usuário digitou.
- **Validação no servidor:** conferir título, importância e data antes de salvar, sem confiar só no formulário.
- **Padrão Post/Redirect/Get:** redirecionar após o envio do formulário evita que a tarefa seja duplicada ao atualizar a página.
- **Cookies:** guardar a última importância escolhida para melhorar a experiência de uso.
- **CRUD completo:** *Create*, *Read*, *Update* e *Delete* funcionando de ponta a ponta com PHP e MySQL.
- **CSS na prática:** tema escuro, layout responsivo, *badges*, transições e uma caixinha de seleção personalizada.
- **Cache do navegador:** descobrimos que o CSS antigo pode ficar guardado; a solução foi versionar o link do arquivo (`style.css?v=...`).
- **Trabalho com Git e GitHub:** versionamento do projeto a cada nova funcionalidade.

 
 
<div align="center">
Se gostou do projeto, deixe uma ⭐ no repositório
 
</div>
 
