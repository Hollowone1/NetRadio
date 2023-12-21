<?php

use radio\net\app\action\Action;
use radio\net\domaine\entities\Playlist;
use radio\net\domaine\service\playlist\PlaylistService;

class GetPlaylistByIdAction extends Action
{
    function __invoke(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args)
    {
        $id = $args['id_playlist'] ?? null;
        $playlistService = new PlaylistService();
        $playlist = $playlistService->getPlaylistById($id);
        $data = [
            'type' => 'resource',
            'playlist' => $playlist
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}