# BlankLaraVue

O objetivo desse projeto é disponibilizar um projeto Blank com Laravel (v. 8) e VueJS (v. 2.6) configurados. Além disso está sendo utilizada a biblioteca de componentes Vuetify.

## Requisitos

- PHP (versão 7.4.33)
- Node.js (versão 14.0.0)
- npm (versão 6.14.4)
- composer (versão 2.x)

## Instalação

1. Clone o repositório: `git clone https://github.com/jmoreirafilho/BlankLaraVue.git`
2. Entre na pasta do Projeto e clone o repositório: `git clone https://github.com/Laradock/laradock.git`
3. Entre na pasta do Laradock e clone o arquivo `.env.exemplo`, alternado seu nome para `.env`
4. Entre no arquivo .env e altere as variaveis:
```
> "DATA_PATH_HOST" => Adicione "/blanklaradock" no final da variavel
> "MYSQL_DATABASE" => Altere o valor para "laravue"
```
5. Dentro da pasta do laradock, execute o comando:`docker-compose up -d nginx mysql phpmyadmin redis workspace`
6. Na pasta **/BlankLaraVue/** clone o arquivo `.env.exemplo`, alternado seu nome para `.env`
7. Entre no container "workspace" gerado na sua docker e execute os comandos:
```
> composer i
> php artisan key:generate
> php artisan migrate
> php artisan db:seed
> chmod -R 777 storage
```

## Uso

Ao executar o passo 5 da instalação, sua aplicação estará funcionando em http://localhost/

Para acessar o PhpMyAdmin, ele estará funcionando em http://localhost:8081/