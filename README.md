
# Prueba tecnica Global Std

## Tecnología

El presente proyecto se encuentra desarrollado con el siguiente STACK:

| Tech | README |
| ------ | ------ |
| PHP 8.2 | https://www.php.net/releases/8.2/en.php|
| Composer | https://getcomposer.org|
| Node.js 20.4.0 | https://nodejs.org|
| Laravel 10.19.0 | https://laravel.com|
| Optional Docker compose v2.19.1 | https://docs.docker.com/compose|
| Optional: Docker desktop | https://www.docker.com/products/docker-desktop|
| Optional: Docker desktop | https://www.docker.com/products/docker-desktop|
| Optional Windows Installation: Docker wsl | https://docs.docker.com/desktop/wsl|


## Configurations and environment

On laravel is needed an ***.env*** file to setting internal configurations, you can use the .env.example to generate your environment file.  

There are an important setting for your app:  

**Database:** Please be sure that you are setting correctly like these:

```sh
DB_CONNECTION=pgsql
DB_HOST=db-movies
DB_PORT=5432
DB_DATABASE=movies
DB_USERNAME=postgres
DB_PASSWORD=postgres
```  

## Installation

There's 2 ways to install and start to develop this template:

- Install docker desktop on dev's PC
- Install all environment and dependencies (PHP, MySQL, Appache/Nginx, Node.js)

Definitely the second way can be tedious and long time installation, anyways, you (the dev), decides which one is your best choice: May the Force be with you!.

- NOTE: If you decided for the first option you need to verify hardware's requirements on docker desktop docs.

## Docker and containers

```sh
cd ~/{app-dir}/src/
```

Now, assumme that you installed Docker desktop and all their dependencies it's time to build your first Container. Please be sure that your terminal is located on the root directory of your app your Scaffolding looks like this  


```sh
-- movies/src  
        -- app/  
        -- docker/  
            -- nginx/  
                -- app.conf  
        -- .dockerignore  
        -- docker-compose.yml
        -- Dockerfile  
    -- .env
```

Then you need to run this command to build your containers:  

```sh
docker-compose up -d
```

Once you run the command describe above and in your terminal outputs are OK, you can check which containers are runing and building with this command:


```sh
docker-compose ps
```  

There are some impotant commands to prepare your environment:  

1. Install composer dependencies 

```sh
docker-compose exec app-movies composer i
```  

2. Run migrations 

```sh
docker-compose exec app-movies php artisan migrate
```  

3. Run seeders:  

```sh
docker-compose exec app-movies php artisan db:seed
```  

4. Create symbolyc link:  

```sh
docker-compose exec app-movies php artisan storage:link
```  

5. Generate new jwt token:  

```sh
docker-compose exec app-movies php artisan jwt:secret
``` 

6. Clear cache:  

```sh
docker-compose exec app-movies php artisan cache:clear
``` 

7. Clear routes:  

```sh
docker-compose exec app-movies php artisan routes:clear
``` 

8. Install node dependencies:  

```sh
    cd ~/movies/src/ 
    npm i
```  

9. Run npm watch to generate laravel mix assets:  

```sh
cd ~/movies/src
npm run watch
```  

10. Run on 
http://localhost:8001/

# Local environments

Once you put this repository on local, please run these commands:

1. Install composer dependencies 

```sh
composer i
```  

2. Run migrations 

```sh
php artisan migrate
```  

3. Run seeders:  

```sh
php artisan db:seed
```  

4. Create symbolyc link:  

```sh
php artisan storage:link
```  

5. Generate new jwt token:  

```sh
php artisan jwt:secret
``` 

6. Clear cache:  

```sh
php artisan cache:clear
``` 

7. Clear routes:  

```sh
php artisan routes:clear
``` 

8. Install node dependencies:  

```sh
    cd ~/movies/src/ 
    npm i
```  

9. Run npm watch to generate laravel mix assets:  

```sh
cd ~/movies/src
npm run watch
```  

10. Run on 
http://localhost:8001/

## Login
Please use this credentials

```sh
email alejandrotsu23@gmail.com
pass 12345
```  

