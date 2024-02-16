<?php

namespace radio\net\domaine\middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Jwt
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $next) {

    }
}