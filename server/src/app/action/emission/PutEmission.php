<?php

namespace radio\net\app\action\emission;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\emission\iEmissionService;

class PutEmission extends Action
{

    public iEmissionService $emissionService;

    public function __construct(iEmissionService $emissionService) {
        $this->emissionService = $emissionService;
    }

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        // TODO: Implement __invoke() method.
    }
}