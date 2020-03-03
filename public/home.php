<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("<h1>Hello!</h1>");
    $response->getBody()->write("<p>Here is your token:</p>");

    $factory = new \PsrJwt\Factory\Jwt();

    $builder = $factory->builder();

    $token = $builder->setSecret('!secReT$123*')
        ->setPayloadClaim('uid', 12)
        ->setExpiration(time() + 600)
        ->build();

    $tokenString = $token->getToken();

    $response->getBody()->write("<p>" . $tokenString . "<p>");
    
    $response->getBody()->write('<p><a href="/token/read?jwt=' . $tokenString . '">Read Token</a></p>');

    $response->getBody()->write('<p><a href="/advanced">Advanced</a></p>');

    $response->getBody()->write('<p><a href="/curl">Curl</a></p>');

    $response->getBody()->write('<p><a href="/custom">Custom</a></p>');

    return $response;
});