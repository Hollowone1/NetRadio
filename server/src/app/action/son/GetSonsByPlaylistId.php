<?php
namespace radio\net\app\action\son;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\entities\Son;
use radio\net\domaine\service\son\iSonService;
use radio\net\domaine\service\son\SonNotFoundException;
use radio\net\domaine\service\son\SonService;

class GetSonsByPlaylistId extends Action
{
    private iSonService $sonService;
    public function __construct(iSonService $son_service)
    {
        $this->sonService = $son_service;
    }

    /**
     * @throws SonNotFoundException
     */
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $idPlaylist = $args['id_playlist'];
        $sons = $this->sonService->getSonsByPlaylistId($idPlaylist);
        $data = [
            'type' => 'resource',
            'sons' => $sons
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}