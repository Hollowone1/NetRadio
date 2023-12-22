<?php
namespace radio\net\app\action\playlist;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\entities\Playlist;
use radio\net\domaine\service\playlist\iPlaylistService;
use radio\net\domaine\service\playlist\PlaylistService;

class GetPlaylistByIdAction extends Action
{
    private iPlaylistService $playlistService;
    public function __construct(PlaylistService $playlist_service)
    {
        $this->playlistService = $playlist_service;
    }
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id_playlist'] ?? "lol";
        $playlist = $this->playlistService->getPlaylistById($id);
        $data = [
            'type' => 'resource',
            'playlist' => $playlist
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}