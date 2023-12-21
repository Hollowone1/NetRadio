<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\GenerateAction;
use radio\net\domaine\entities\Son;

class GetSonByIdAction extends \radio\net\app\action\Action
{
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $idSon = $args['id_son'];
        $son = new Son();
        $son->id = $idSon;
        $son = $son->find($idSon);
        $data = [
            'type' => 'resource',
            'son' => $son
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}