<?php

namespace radio\net\app\action\auth;

use radio\net\domaine\dto\TokenDTO;
use radio\net\domaine\service\auth\AuthServiceInvalidTokenException;
use radio\net\domaine\service\auth\AuthServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Routing\RouteContext;

class RefreshAction extends Action
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
            $token = $request->getHeader('Authorization')[0];
            $token = str_replace('Bearer ', '', $token);

            $tokenDTO = $this->serviceAuth->refresh(new TokenDTO(null, $token));

            $response->getBody()->write($tokenDTO->toJson());

            return $response->withStatus(201)->withHeader('Content-Type', 'application/json;charset=utf-8');
        } catch (AuthServiceInvalidTokenException $e) {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();

            $response->getBody()->write(json_encode(['error' => 'Invalid', 'message' => $e->getMessage()]));
            return $response->withStatus(401)->withHeader('Location', $routeParser->urlFor('signin'))->withHeader('Content-Type', 'application/json;charset=utf-8');
        }
    }
}
