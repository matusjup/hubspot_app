 
## HubSpot custom app

Create .env file from .env.example

**To start docker**
First time you start you need to build the image 
> docker-compose up -d --build
Every next time, when you start
> docker-compose up -d

**Commands**
1. For composer commands 
> docker exec hubspot_app composer || do composer install

2. For Node commands
> docker run --rm -w /home/node/app -v $PWD:/home/node/app node:16 npm install || do npm install

3. For Artisan commands
> docker exec hubspot_app php artisan ... || do php artisan migrate

**To stop docker**
> docker-compose down

**Commands**
> docker exec hubspot_app php artisan make:export ExampleExport --model=Example
> docker exec hubspot_app php artisan make:controller ExampleController
> docker exec hubspot_app php artisan make:controller API/ExampleController --api --model=Example
> docker exec hubspot_app php artisan make:model Example
> docker exec hubspot_app php artisan make:seeder ExampleSeeder
> docker exec hubspot_app php artisan make:migration CreateExamplesTable
> docker exec hubspot_app php artisan make:command Example
> docker exec hubspot_app php artisan make:observer ExampleObserver --model=Example
> docker exec hubspot_app php artisan make:middleware ExampleMiddleware
> docker exec hubspot_app php artisan command:example
> docker exec hubspot_app php artisan migrate:fresh
> docker exec hubspot_app php artisan db:seed
> docker exec hubspot_app php artisan make:migration add_example_to_exampless_table --table=examples
> docker exec hubspot_app php artisan make:migration drop_example_from_examples_table --table=examples
> docker exec hubspot_app php artisan make:migration drop_example_table
