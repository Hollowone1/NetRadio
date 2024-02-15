<?php

namespace radio\net\app\action\auth;

use radio\net\domaine\dto\CredentialsDTO;
use radio\net\domaine\service\auth\AuthServiceCredentialsException;
use radio\net\domaine\service\auth\AuthServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use Slim\Exception\HttpUnauthorizedException;

class SigninAction extends Action
{
    private AuthServiceInterface $serviceAuth;

    public function __construct(AuthServiceInterface $serviceAuth)
    {
        $this->serviceAuth = $serviceAuth;
    }

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if (!$request->hasHeader('Authorization')) {
            throw new HttpUnauthorizedException($request, "missing Authorization Header");
        }

        try {
            $credentials = $request->getHeader('Authorization')[0];
            $credentials = str_replace('Basic ', '', $credentials);
            $credentials = base64_decode($credentials);
            $credentials = explode(':', $credentials);

            if (count($credentials) !== 2) {
                return $response->withStatus(400);
            }

            $tokenDTO = $this->serviceAuth->signin(new CredentialsDTO($credentials[0], $credentials[1]));

            $response->getBody()->write($tokenDTO->toJson());

            return $response->withStatus(201)->withHeader('Content-Type', 'application/json;charset=utf-8');
        } catch (AuthServiceCredentialsException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json;charset=utf-8');
        }
    }
}
