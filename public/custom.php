<?php

use PsrJwt\Auth\Authorise;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class MyHandler extends Authorise implements RequestHandlerInterface
{
    public function __construct(string $secret, string $tokenKey)
    {
        parent::__construct($secret, $tokenKey);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $auth = $this->authorise($request);

        return new Response(
            $auth->getCode(),
            [],
            '<h1>Custom Fail!</h1><p><a href="/custom">Back</a></p>',
            '1.1',
            $auth->getMessage()
        );
    }
}

$middleware = new PsrJwt\JwtAuthMiddleware(new MyHandler('!secReT$123*', 'jwt'));

$app->get('/custom', function (ServerRequestInterface $request, ResponseInterface $response) {
    
    $response->getBody()->write('<h1>Custom</h1>');

    $factory1 = new \PsrJwt\Factory\Jwt();

    $builder1 = $factory1->builder();

    $token1 = $builder1->setSecret('!secReT$123*')
        ->setPayloadClaim('uid', 12)
        ->setExpiration(time() + 600)
        ->build();

    $tokenString1 = $token1->getToken();

    $response->getBody()->write("<p>" . $tokenString1 . "<p>");
    
    $response->getBody()->write('<p><a href="/custom/validate?jwt=' . $tokenString1 . '">Validate Success</a></p>');

    $factory2 = new \PsrJwt\Factory\Jwt();

    $builder2 = $factory2->builder();

    $token2 = $builder2->setSecret('!secReT$123*')
        ->setPayloadClaim('uid', 12)
        ->setPayloadClaim('exp', time() - 600)
        ->build();

    $tokenString2 = $token2->getToken();

    $response->getBody()->write("<p>" . $tokenString2 . "<p>");
    
    $response->getBody()->write('<p><a href="/custom/validate?jwt=' . $tokenString2 . '">Validate Failure</a></p>');
    
    $response->getBody()->write('<p><a href="/">Back</a></p>');
    
    return $response;
});

$app->get('/custom/validate', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write("<h1>Custom OK!</h1>");
    $response->getBody()->write('<p><a href="/custom">Back</a></p>');
    return $response;
})->add($middleware);