<?php

namespace radio\net\app\action\user;

use radio\net\app\action\Action;
use radio\net\domaine\dto\PodcastDTO;
use radio\net\domaine\service\user\iUserService;
use Slim\Routing\RouteContext;

class PostUser extends Action
{
    private iUserService $service;

    public function __construct ($userService) {
        $this->service = $userService;
    }

    function __invoke(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args)
    {
        $routerContext = RouteContext::fromRequest($request);
        $router = $routerContext->getRouteParser();
        $data = json_decode($request->getBody()->getContents(), true);

        $podcastDTO = new PodcastDTO(
            $data['titre'],
            $data['description'],
            $data['duree'],
            $data['date'],
            $data['audio'],
            $data['photo'],
            $data['emission_id']
        );

        $podcast = $this->podcastService->postPodcast($podcastDTO);

        $dataJson = [
            'id' => $podcast->id,
            'titre' => $podcast->titre,
            'description' => $podcast->description,
            'duree' => $podcast->duree,
            'date' => $podcast->date,
            'audio' => $podcast->audio,
            'photo' => $podcast->photo,
            'links' => [
                'self' => [
                    "href" => $router->urlFor('podcast.show', ['id_podcast' => $podcastDTO->id]),
                ],
                'emission' => [
                    "href" => $router->urlFor('emission.show', ['id_emission' => $podcastDTO->idEmission]),
                ],
            ]
        ];

        $data = [
            'type' => 'resource',
            'podcasts' => $dataJson
        ];

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}