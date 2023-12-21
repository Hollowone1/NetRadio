<?php

use radio\net\app\action\Action;
use radio\net\domaine\entities\Playlist;

class GetPlaylistByIdAction extends Action
{
    function __invoke(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args)
    {
        $id = $args['id_playlist'] ?? 0;
        $playlist = new Playlist();
        $playlist = $playlist->findById($id);
        $data = [
            'type' => 'resource',
            'playlist' => $playlist
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}