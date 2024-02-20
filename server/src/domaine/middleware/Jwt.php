<?php

namespace radio\net\domaine\middleware;

use Psr\Http\Server\RequestHandlerInterface;
use radio\net\domaine\dto\TokenDTO;
use radio\net\domaine\service\auth\AuthServiceExpiredTokenException;
use radio\net\domaine\service\auth\AuthServiceInvalidTokenException;
use radio\net\domaine\service\auth\AuthServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Routing\RouteContext;

class Jwt
{
    private AuthServiceInterface $serviceAuth;

    public function __construct(AuthServiceInterface $serviceAuth)
    {
        $this->serviceAuth = $serviceAuth;
    }

    function __invoke(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        if (!$request->hasHeader('Authorization')) {
            throw new HttpUnauthorizedException($request, "missing Authorization Header");
        }

        $token = $request->getHeader('Authorization')[0];
        $token = str_replace('Bearer ', '', $token);
        try {

            $userDTO = $this->serviceAuth->validate(new TokenDTO($token));

            $request = $request->withAttribute('user', $userDTO);
        } catch (AuthServiceExpiredTokenException $e) {
            return $next->handle($request)->withStatus(401)->withHeader('Location', $routeParser->urlFor('signin'));
        } catch (AuthServiceInvalidTokenException $e) {
            return $next->handle($request)->withStatus(401)->withHeader('Location', $routeParser->urlFor('refresh'));
        }
        return $next->handle($request);
    }
}
