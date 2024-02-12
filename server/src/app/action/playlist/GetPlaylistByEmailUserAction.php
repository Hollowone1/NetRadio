<?php

namespace radio\net\app\action\playlist;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\playlist\iPlaylistService;
use radio\net\domaine\service\playlist\PlaylistNotFoundException;
use radio\net\domaine\service\playlist\PlaylistService;

class GetPlaylistByEmailUserAction extends Action
{
    private iPlaylistService $playlistService;
    public function __construct(PlaylistService $playlist_service)
    {
        $this->playlistService = $playlist_service;
    }

    /**
     * @throws PlaylistNotFoundException
     */
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $emailUser = $args['email_user'];
        $playlists = $this->playlistService->getPlaylistsByEmailUser($emailUser);
        $data = [
            'type' => 'resource',
            'playlists' => $playlists
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }


}