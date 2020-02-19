<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("<h1>Hello!</h1>");
    $response->getBody()->write("<p>Here is your token:</p>");

    $factory = new \PsrJwt\Factory\Jwt();

    $builder = $factory->builder();

    $token = $builder->setSecret('!secReT$123*')
        ->setPayloadClaim('uid', 12)
        ->build();

    $tokenString = $token->getToken();

    $response->getBody()->write("<p>" . $tokenString . "<p>");
    
    $response->getBody()->write('<p><a href="/token/read?jwt=' . $tokenString . '">Read Token</a></p>');

    return $response;
});

$app->get('/token/read', function (Request $request, Response $response) {
    $helper = new PsrJwt\Helper\Request();

    $header = $helper->getTokenHeader($request, 'jwt');

    $payload = $helper->getTokenPayload($request, 'jwt');

    $response->getBody()->write("<h2>Header</h2>");

    foreach ($header as $key => $value) {
        $response->getBody()->write("<p>" . $key . ": " . $value . "</p>");
    }

    $response->getBody()->write("<h2>Payload</h2>");

    foreach ($payload as $key => $value) {
        $response->getBody()->write("<p>" . $key . ": " . $value . "</p>");
    }

    $response->getBody()->write('<p><a href="/">Back</a></p>');

    return $response;
});

$app->run();
