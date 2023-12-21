<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\entities\Son;
use radio\net\domaine\service\son\SonService;

class GetAllSons extends Action
{

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $sonService = new SonService();
        $sons = $sonService->getAllSons();
        $data = [
            'type' => 'resource',
            'sons' => $sons
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}