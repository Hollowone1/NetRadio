<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\entities\Son;
use radio\net\domaine\service\son\SonService;

class GetSonsByPlaylistId extends Action
{

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $idPlaylist = $args['id_playlist'];
        $sonService = new SonService();
        $sons = $sonService->getSonsByPlaylistId($idPlaylist);
        $data = [
            'type' => 'resource',
            'sons' => $sons
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}