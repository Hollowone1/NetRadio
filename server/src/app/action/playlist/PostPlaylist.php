<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\entities\Playlist;

class PostPlaylist extends Action
{

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $data = $request->getParsedBody();
        $playlist = new Playlist();
        $playlist->setName($data['name']);
        $playlist->setDate($data['date']);
        $playlist->setPodcastId($data['podcast_id']);
        $playlist->setSonId($data['son_id']);
        $playlist->save();
        $data = [
            'type' => 'resource',
            'playlist' => $playlist
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}