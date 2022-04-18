# Coding challenge da Tecnofit

Teste desenvolvido usando as seguintes tecnologias:
- PHP 8.1
- Apache 2.4
- Mysql 8.0
- Framework Laravel 9.8

As tabelas e o conteúdo das mesmas foram criadas no padrão do Laravel
- Migrations para criar as tabelas
- Seeders para popular as tabelas

### Instruções para rodar a aplicação

Antes de rodar a aplicação certifique-se de ter instalado na maquina Docker e o docker-compose.

1) Efetue o clone do repositorio
2) Entre na pasta do projeto e execute o seguinte comando no terminal:

> `docker-compose up -d`

O docker irá fazer o build da imagem que será usada para rodar a aplicação e baixar a imagem do Mysql. Assim que o container subir o entrypoint será executado para fazer as configurações necessárias.

Aguarde o composer baixar as dependências do projeto é possível acompanhar o projeto usando o seguinte comando docker:

`docker logs -f NOME_CONTAINER`

Acesse o seguinte endereço:

http://localhost/api/ranking

Ou:

http://localhost/api/ranking/1

O parâmetro da URL acima é o ID do movement.