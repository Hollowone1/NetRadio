<?php
namespace radio\net\app\action\playlist;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\playlist\iPlaylistService;
use radio\net\domaine\service\playlist\PlaylistService;

class PostPlaylist extends Action
{

    private iPlaylistService $playlistService;
    public function __construct(PlaylistService $playlist_service)
    {
        $this->playlistService = $playlist_service;
    }
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();
        $name = $data['name'];
        $description = $data['description'];
        $emailUser = $data['emailUser'];
        $playlist = $this->playlistService->createPlaylist($name, $description, $emailUser);
        $data = [
            'type' => 'resource',
            'playlist' => $playlist
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}