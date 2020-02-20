<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/advanced', function (Request $request, Response $response) {
    
    $response->getBody()->write('<h1>Advanced</h1>');

    $factory1 = new \PsrJwt\Factory\Jwt();

    $builder1 = $factory1->builder();

    $token1 = $builder1->setSecret('!secReT$123*')
        ->setPayloadClaim('uid', 12)
        ->setExpiration(time() + 600)
        ->build();

    $tokenString1 = $token1->getToken();

    $response->getBody()->write("<p>" . $tokenString1 . "<p>");
    
    $response->getBody()->write('<p><a href="/advanced/validate?jwt=' . $tokenString1 . '">Validate Success</a></p>');

    $factory2 = new \PsrJwt\Factory\Jwt();

    $builder2 = $factory2->builder();

    $token2 = $builder2->setSecret('!secReT$123*')
        ->setPayloadClaim('uid', 12)
        ->setPayloadClaim('exp', time() - 600)
        ->build();

    $tokenString2 = $token2->getToken();

    $response->getBody()->write("<p>" . $tokenString2 . "<p>");
    
    $response->getBody()->write('<p><a href="/advanced/validate?jwt=' . $tokenString2 . '">Validate Failure</a></p>');
    
    $response->getBody()->write('<p><a href="/">Back</a></p>');
    
    return $response;
});

$app->get('/advanced/validate', function (Request $request, Response $response) {
    $response->getBody()->write("<h1>OK!</h1>");
    $response->getBody()->write('<p><a href="/advanced">Back</a></p>');
    return $response;
})->add(\PsrJwt\Factory\JwtMiddleware::html('!secReT$123*', 'jwt', '<h1>Fail!!</h1><p><a href="/advanced">Back</a></p>'));