<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

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