# send4test
Desenvolvimento de software para teste na empresa Send4

## Requisitos:
- Git instalado;
- Docker instalado.

## Instalação/Configuração
Use ```git clone``` para baixar o projeto em sua máquina no diretório de sua escolha, em seguida dê sequência aos seguintes passos:

### 1. Dar build nos contêineres
- Acesse via linha de comando o diretório do projeto e utilize o comando *docker-compose build*
```
docker-compose build
```
### 2. Iniciar a execução dos contêineres
- Ainda no terminal ou PowerShell (Windows):
```
docker-compose up -d
```
- Verifique se todos os 4 contêineres necessários subiram utilizando o comando *docker ps*
```
docker ps
```
- Os 4 contêineres são:
  1. send4test-redis
  2. send4test-mysql
  3. send4test-webserver
  4. send4test-php-fpm
### 3. Acesse o diretório do projeto pegue como exemplo o arquivo *.env.example* criando um arquivo *.env*
### 4. Descubra o IP utilizado pelo container MySQL
- Rode o seguinte comando:
```
docker inspect send4test-mysql
```
- Procure por "IPAddress" e substitua o valor de *DB_HOST* no arquivo .env
### 5. Descubra o IP utilizado pelo container Redis
- Rode o seguinte comando:
```
docker inspect send4test-redis
```
- Procure por "IPAddress" e substitua o valor de *REDIS_HOST* no arquivo .env
### 6. Acesse o contêiner *send4test-php-fpm* para rodar comandos de instalação
- Acesse o container:
```
docker exec -it send4test-php-fpm /bin/bash
```
- Rodar *composer*:
```
composer install
```
- Instalar yarn:
```
apt remove cmdtest
apt remove yarn
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
apt-get update  
apt-get install yarn
```
- Executar comandos yarn:
```
yarn install -g && yarn run dev
```
- Dar permissão de acesso a pasta storage:
```
chmod -R 777 storage
```
- Rodar migrations para criação de tabelas no banco:
```
php artisan migrate
```
- Ativar a fila:
```
php artisan queue:work
```
### 7. Pronto! =D
Agora é só acessar [Send4Test](http://localhost:8080).
