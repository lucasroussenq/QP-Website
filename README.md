CRUD de Viações — Quero Passagem
CRUD para cadastro de viações desenvolvido com PHP, MySQL e Docker.

Tecnologias

PHP 8.5 — backend e renderização das páginas
MySQL 8.0 — banco de dados
Docker + Docker Compose — ambiente de desenvolvimento
HTML/CSS — interface sem frameworks


Funcionalidades

Listar viações com filtro por nome (autocomplete) e status
Cadastrar viação com upload de logo
Editar viação
Excluir viação (com modal de confirmação)
Histórico de alterações com diff visual (antes × depois)


Estrutura de Arquivos
crud-viacoes/
├── Dockerfile
├── docker-compose.yml
├── composer.json
└── src/
├── partials/
│   └── form.php       # campos reutilizáveis do formulário
├── uploads/           # logos enviadas pelos usuários
├── db.php             # conexão com o banco e criação da tabela
├── index.php          # listagem + filtros
├── create.php         # cadastro
├── edit.php           # edição
├── delete.php         # exclusão
├── logs.php           # histórico de alterações
└── script.js          # autocomplete e modal de exclusão

Como rodar
1. Subir os containers:
   bashdocker compose up -d --build
2. Verificar se estão rodando:
   bashdocker compose ps
3. Acessar no navegador:
   http://localhost:8080
4. Derrubar o ambiente:
   bashdocker compose down

Banco de dados
A tabela bus_companies é criada automaticamente ao subir o projeto.
sqlCREATE TABLE bus_companies (
id         INT AUTO_INCREMENT PRIMARY KEY,
name       VARCHAR(100)  NOT NULL,
url        VARCHAR(255)  NOT NULL,
city       VARCHAR(100)  NOT NULL,
status     ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
logo       VARCHAR(255)  NULL,
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
A tabela bus_company_logs registra todas as ações de criação, edição e exclusão:
sqlCREATE TABLE bus_company_logs (
id              INT AUTO_INCREMENT PRIMARY KEY,
bus_company_id  INT NOT NULL,
action          ENUM('create', 'update', 'delete') NOT NULL,
old_value       JSON NULL,
new_value       JSON NULL,
created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

Conexão com o banco (opcional — IDE)
CampoValorHostlocalhostPort3307DatabaseviacoesUserappPasswordapp123

Credenciais Docker
Definidas no docker-compose.yml:
VariávelValorMYSQL_DATABASEviacoesMYSQL_USERappMYSQL_PASSWORDapp123MYSQL_ROOT_PASSWORDroot123