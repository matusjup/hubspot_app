 
## HubSpot custom app

Create .env file from .env.example

You need API keys from the owner of the project.

**To start docker**

First time you start you need to build the image 
```
docker-compose up -d --build
```
Every next time, when you start
```
docker-compose up -d
```

**Commands**
1. For composer commands 
```
docker exec hubspot_app composer
```
2. For Node commands
```
docker run --rm -w /home/node/app -v $PWD:/home/node/app node:16 npm
```

3. For Artisan commands
```
docker exec hubspot_app php artisan
```

**To stop docker**
```
docker-compose down
```

**Commands**
```
docker exec hubspot_app composer install
docker exec hubspot_app php artisan key:generate
docker exec hubspot_app php artisan migrate:fresh --seed
docker run --rm -w /home/node/app -v $PWD:/home/node/app node:16 npm install
docker run --rm -w /home/node/app -v $PWD:/home/node/app node:16 npm run watch
```
