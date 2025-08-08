## Mapa Cidadão API

<b> Mapa Cidadão API</b> é uma aplicação desenvolvida em Laravel que permite o registro e monitoramento de ocorrências urbanas em um mapa interativo. Com foco em participação cidadã e gestão urbana, a API possibilita que usuários registrem problemas como:

-   🗑️ Acúmulo de lixo

-   💡 Falta de iluminação pública

-   🛣️ Problemas de pavimentação

-   🌊 Alagamentos

-   🚧 Outros tipos de ocorrências

Cada ocorrência cadastrada contém:

-   📍 A localização geográfica precisa do problema (via coordenadas do usuário)

-   📝 Uma descrição breve do que está acontecendo

-   🏷️ Um tipo pré-definido de ocorrência

O objetivo principal do projeto é fornecer uma base de dados georreferenciada para que prefeituras, gestores públicos e cidadãos possam visualizar, acompanhar e priorizar ações de manutenção urbana com base em dados colaborativos.

A Mapa Cidadão API serve como backend de uma aplicação web e oferece uma interface RESTful para integração com frontends modernos.

### 🛠️ Tecnologias

<img  
    align="left" 
    alt="PHP" 
    title="PHP"
    width="30px" 
    style="padding-right: 10px;" 
    src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg" />
<img 
    align="left" 
    alt="Laravel" 
    title="Laravel"
    width="30px" 
    style="padding-right: 10px;" 
    src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg" 
/>

<img 
    align="left" 
    alt="Laravel" 
    title="Laravel"
    width="30px"
    style="padding-right: 10px;"
    src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/docker/docker-original.svg" 
 />

 <img 
    align="left" 
    alt="Laravel" 
    title="Laravel"
    width="30px"
    style="padding-right: 10px;"
    src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/postgresql/postgresql-original.svg" 
 />

<br>
<br>

* PHP 8.4
* Laravel 12
* Docker
* PostgreSQL
* PostGIS

### 🚀 Instalação

#### 1. Clonar o repositóirio
```
git clone https://github.com/MateusViniMelo/mapa_cidadao_api.git
cd mapa_cidadao_api
 ```


#### 2. Copiar e Configurar Containers
 ```
 cp docker-compose.example.yml docker-compose.yml
 docker compose up -d
  ```
#### 3. Copiar e configurar
```
cp .env.example .env
cp .env.example.testing .env.testing

 ```

#### 4. Entrar no container app
```
docker compose exec app bash
```
#### 4.1 configurar .env e .env.testing
```
php artisan key:generate
php artisan key:generate --env=testing
```

#### 4.2 Instalar dependências do projeto
```
composer install
```

#### 4.3 Rodar testes
```
composer test
```

Aplicação rodando em `` http://localhost:8000/``