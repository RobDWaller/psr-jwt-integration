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
    $response->getBody()->write('<p><a href="http://localhost:8888">Validate Fail</a></p>');
    $response->getBody()->write('<p><a href="http://localhost:8080">Back</a></p>');
    return $response;
});

$app->post('/curl/validate', function (Request $request, Response $response) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write('{"OK!!"}');
    return $response;
})->add(\PsrJwt\Factory\JwtMiddleware::json('!secReT$123*', 'jwt', ['Fail!!']));