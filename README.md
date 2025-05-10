# Documentação - Holiday Plan - Buzzvel

Dependências Utilizadas:
- Laravel 9 - https://laravel.com/docs/9.x
- Laravel Passport - https://laravel.com/docs/12.x/passport
- PHPUnit - https://laravel.com/docs/12.x/testing

## URL para teste da aplicação
Para testar a aplicação em tempo real, utilize a URL abaixo em sua ferramenta de testes de API(Postman, Insomnia) junto com as rotas definidas na sessão [Rotas e Endpoints](#rotas-e-endpoints)
- `https://buzzvel.upsilan.com.br/`

## Instalação do projeto e dependências
Primeiramente, você deve clonar o repositório no seu ambiente local usando o comando:
- `$ git clone https://github.com/raborzoni/holiday-plan.git`
- `$ cd holiday-plan`

Após o clone, instale as dependências do projeto com o comando:
- `$ composer install`

Copie o arquivo .env.example para .env com o comando:
- `$ cp .env.example .env`

Gere uma nova key do Laravel para o seu projeto:
- `$ php artisan key:generate`

Teste o sistema:
- `$ php artisan serve`

## Configuração do Banco de Dados
### Crie um Banco de Dados MySQL.
No arquivo .env, preencha os dados do Banco criado:
- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=nome_do_banco`
- `DB_USERNAME=root`
- `DB_PASSWORD=sua_senha`

Execute o comando para migrar as tabelas do projeto:
- `$ php artisan migrate –seed`

Instale o Passport para autenticar o Client do Laravel Passport:
- `$ php artisan passport:install`

## Rotas e Endpoints
### As rotas públicas, para Registro e Login do usuário:

### Registro:
- POST /api/register

Os parâmetros para criação do usuário:
```json
{
    "name": "Admin",
    "email": "admin@buzzvel.com",
    "password": "1234",
    "password_confirmation": "12345"
}
```

Resposta com o Bearer Token:
```json
{
    "message": "User created SUCCESSFULLY! Enjoy your Holiday plan Admin!",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiO..."
}
```
Guarde esse Bearer Token.


### Login:
- POST /api/login

Os parâmetros para login do usuário:
```json
{
    "email": "admin@buzzvel.com",
    "password": "12345"
}
```
Resposta com o Bearer Token:
```json
{
    "message": "Welcome to BUZZVEL and your HOLIDAY PLANNING Admin!",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJh..."
}
```
Guarde esse Bearer Token.

### As rotas protegidas, para uso do usuário autenticado com o Bearer Token:

### Todos os planos:
- GET /api/holidays

Resposta:
```json
{
    "message": "Here are your plans registered so far!!",
    "0": [
        {
            "id": 1,
            "title": "Holiday Plan Example",
            "description": "Holiday Plan Example.",
            "date": "2025-06-08",
            "location": "Rio de Janeiro, BR",
            "participants": [
                "Admin Buzzvel"
            ],
            "created_at": "2025-05-09T12:37:36.000000Z",
            "updated_at": "2025-05-09T12:37:36.000000Z"
        }
    ]
}
```
### Criação de um Plano:
- POST /api/holidays

Parâmetros para a criação:
```json
{
    "title": "Holiday Plan Example 2",
    "description": "Holiday Plan Example 2.",
    "date": "2025-06-08",
    "location": "Rio de Janeiro, BR",
    "participants": ["Admin Buzzvel1", "Admin Buzzvel2"]
}
```
Resposta:
```json
{
    "message": "Holiday Plan created successfully!!",
    "0": {
        "title": "Holiday Plan Example 2",
        "description": "Holiday Plan Example 2.",
        "date": "2025-06-08",
        "location": "Rio de Janeiro, BR",
        "participants": ["Admin Buzzvel1", "Admin Buzzvel2"],
        "updated_at": "2025-05-09T01:24:44.000000Z",
        "created_at": "2025-05-09T01:24:44.000000Z",
        "id": 2
    }
}
```
### Plano específico:
GET /api/holidays/{id}

Resposta:
```json
{
    "message": "Here is your plan Admin.",
    "0": {
        "id": 1,
        "title": "Holiday Plan Example",
        "description": "Exemplo de plano de férias.",
        "date": "2025-06-08",
        "location": "Rio de Janeiro, BR",
        "participants": [
            "Admin Buzzvel"
        ],
        "created_at": "2025-05-09T12:37:36.000000Z",
        "updated_at": "2025-05-09T12:37:36.000000Z"
    }
}
```
### Atualização do plano:
PUT /api/holidays/{id}

Parâmetro para atualização:
```json
{
    "title": "Update Holiday Plan",
    "description": "Updated Holiday Plan",
    "date": "2025-06-08",
    "location": "Rio de Janeiro, Brasil",
    "participants": ["Admin Buzzvel"]
}
```
Resposta:
```json
{
    "message": "Plan updated successfully!!",
    "0": {
        "id": 1,
        "title": "Update Holiday Plan",
        "description": "Updated Holiday Plan",
        "date": "2025-06-08",
        "location": "Rio de Janeiro, Brasil",
        "participants": [
            "Admin Buzzvel"
        ],
        "created_at": "2025-05-09T12:37:36.000000Z",
        "updated_at": "2025-05-09T13:39:10.000000Z"
    }
}
```
Observação:
Para editar o plano, não é obrigatório o preenchimento de todos os campos. Você pode modificar campos específicos.

### Gerar PDF do plano específico:
GET /api/holidays/{id}/pdf

É gerado um documento PDF com o plano definido.

### Deletar plano:
DELETE /api/holidays/{id}

Resposta:
```json
{
    "message": "Deleted successfully!"
}
```
### Logout:
POST /api/logout

Para desconectar o usuário do sistema, você precisa estar com o Token gerado e autenticado no sistema.
Resposta:
```json
{
    "message": "Bye, bye!"
}
```
## Testes Automatizados
O sistema obtém testes automatizados nativos do Laravel. Para executar os testes, acesse o terminal e execute o comando:
- `$ php artisan test`

Serão testados os métodos de Plano de Férias.

### Observação: 
Após os testes serem executados, é necessário que refaça os comandos Migrate e Passport Install.

Para limpar os testes do banco e subir novamente o migrate e os seeders:
- `$ php artisan migrate:fresh –seed`

Para instalar novamente o Laravel Passport:
- `$ php artisan passport:install –force`

Logo depois, o serviço será normalizado.
