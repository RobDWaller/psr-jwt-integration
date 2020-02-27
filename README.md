# PSR-JWT Integration Test

This is the integration testing tool for the [PSR-JWT Library](https://github.com/RobDWaller/psr-jwt). It spins up a simple Slim PHP based website which allows you to check the PSR-JWT middleware works as expected in the wild.

## Setup

Requires Docker, and has two environments, one for standard web checks and one for making CURL requests for testing the bearer token implementation.

Spin up environments:

```bash
docker-compose up -d
```

Turn on website:

```bash
docker-compose exec psr-jwt bash
composer update
cd public
php -S 0.0.0.0:8080
```

Turn on CURL endpoints:

```bash
docker-compose exec curl bash
php -S 0.0.0.0:8888
```

Once everything on you can access and navigate the site at [localhost:8080](http://localhost:8080).