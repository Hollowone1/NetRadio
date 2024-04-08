<?php

namespace radio\net\app\action\playlist;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\dto\SonDTO;
use radio\net\domaine\service\playlist\iPlaylistService;
use Slim\Routing\RouteContext;

class PostSonByPlaylistAction extends Action
{
    private iPlaylistService $iPlaylistService;

    public function __construct($playlistService)
    {
        $this->iPlaylistService = $playlistService;
    }

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $routerContext = RouteContext::fromRequest($request);
        $router = $routerContext->getRouteParser();
        $data = json_decode($request->getBody()->getContents(), true);
        $sonDTO = new SonDTO(
            $data['son']['titre'],
            $data['son']['nomArtiste'],
            $data['son']['audio']
        );

        $playlist = $this->iPlaylistService->postSonByPlaylist($data['idPlaylist'] ,$sonDTO);

        $dataJson = [
            'id' => $playlist->id,
            'titre' => $playlist->name,
            'description'=> $playlist->description,
            'links' => [
                'self' => [
                    "href" => $router->urlFor('playlist.show', ['id_playlist' => $playlist->id])
                ],
                'users' => [
                    "href" => $router->urlFor('user.show', ['email' => $playlist->emailUser])
                ],
                'sons' => [
                    "href" => $router->urlFor('sons.playlist', ['id_playlist' => $playlist->id])
                ],
            ]
        ];

        $data = [
            'type' => 'resource',
            'playlist' => $dataJson
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

}