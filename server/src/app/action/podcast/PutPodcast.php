<?php

namespace radio\net\app\action\podcast;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\dto\PodcastDTO;
use radio\net\domaine\service\podcast\iPodcastService;
use radio\net\domaine\service\podcast\PodcastNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class PutPodcast extends Action
{
    private iPodcastService $iPodcastService;
    public function __construct($podcastService)
    {
        $this->iPodcastService = $podcastService;
    }

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        try {
            $routeContext = RouteContext::fromRequest($request);
            $router = $routeContext->getRouteParser();

            //récupération du podcast avec l'id
            $id = $args['id'];
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
            $podcastDTO->setId($id);

            //modification du podcast
            $podcast = $this->iPodcastService->putPodcast($podcastDTO);

            // les mettre sous la format json
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

            //envoie des données
            $data = [
                'type' => 'resource',
                'podcasts' => $dataJson
            ];

            $response->getBody()->write(json_encode($data));
            return $response;
        } catch (PodcastNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }


    }
}