# ![alt text](pokeball-rotate.png) Pokédex

Este é um projeto de Pokédex que utiliza Laravel.

## 🧐 Observação: 

Para executar este projeto é necessário ter instalado:
- Docker
- git

## 💻 Como Rodar

1. Clone este repositório.
  `https://github.com/DayaneCristina/pokedex-back`
2. Na raiz do pojeto rode o comando `docker-compose up -d`.
3. Após os containers subirem, rode os comandos abaixo:

> Para instalar as dependências: <br>
`docker exec -it pokedex.api bash -c "composer install"`

> Para gerar uma APP_KEY: <br>
`docker exec -it pokedex.api bash -c "php artisan key:generate"`

> Para gerar a JWT_KEY: <br>
`docker exec -it pokedex.api bash -c "php artisan jwt:secret"`

> Para gerar a base e popular a tabela de usuários: <br>
`docker exec -it pokedex.api bash -c "php artisan migrate:refresh --seed"`

## 🎮 Uso
A aplicação ficará disponível em `http://localhost:3333/api`.

## **Tecnologias Utilizadas:**

<div style="display: inline_block">
  <img align="center" alt="icone-github" height="50" src="https://github.com/devicons/devicon/blob/master/icons/github/github-original.svg">
  &nbsp;&nbsp;
    <img align="center" alt="icone-vs-code" height="50" src="https://github.com/devicons/devicon/blob/master/icons/vscode/vscode-original.svg">
  &nbsp;&nbsp;
    <img align="center" alt="icone-laravel" height="50" src="https://github.com/devicons/devicon/blob/master/icons/laravel/laravel-line-wordmark.svg">
  &nbsp;&nbsp;
    <img align="center" alt="icone-php" height="50" src="https://github.com/devicons/devicon/blob/master/icons/php/php-original.svg">
  &nbsp;&nbsp;
    <img align="center" alt="icone-docker" height="50" src="https://github.com/devicons/devicon/blob/master/icons/docker/docker-original-wordmark.svg">
  &nbsp;&nbsp;
    <img align="center" alt="icone-postgresql" height="50" src="https://github.com/devicons/devicon/blob/master/icons/postgresql/postgresql-original-wordmark.svg">
  &nbsp;&nbsp;
</div>
