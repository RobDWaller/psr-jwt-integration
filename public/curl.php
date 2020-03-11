<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/curl', function (Request $request, Response $response) {
    
    $factory = new \PsrJwt\Factory\Jwt();

    $builder = $factory->builder();

    $token = $builder->setSecret('!secReT$123*')
        ->setPayloadClaim('uid', 12)
        ->setExpiration(time() + 600)
        ->build();

    $tokenString = $token->getToken();

    $response->getBody()->write("<h1>CURL Test</h1>");
    $response->getBody()->write('<p><a href="http://localhost:8888?token=' . $tokenString . '">Validate Success</a></p>');
    
    $factory1 = new \PsrJwt\Factory\Jwt();

    $builder1 = $factory1->builder();

    $token1 = $builder1->setSecret('!secReT$123*')
        ->setPayloadClaim('uid', 15)
        ->setPayloadClaim('exp', time() - 600)
        ->build();

    $tokenString1 = $token1->getToken();
    
    $response->getBody()->write('<p><a href="http://localhost:8888?token=' . $tokenString1 . '">Validate Fail</a></p>');
    $response->getBody()->write('<p><a href="http://localhost:8080">Back</a></p>');
    return $response;
});

$app->post('/curl/validate', function (Request $request, Response $response) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write('{"OK!!"}');
    return $response;
})->add(\PsrJwt\Factory\JwtMiddleware::json('!secReT$123*', 'jwt', ['Fail!!']));