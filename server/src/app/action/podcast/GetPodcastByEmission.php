<?php

namespace radio\net\app\action\podcast;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\podcast\iPodcastService;
use radio\net\domaine\service\podcast\PodcastNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class GetPodcastByEmission extends Action
{
    private iPodcastService $podcastService;
    public function __construct (iPodcastService $iPodcastService) {
        $this->podcastService = $iPodcastService;
    }
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        // obtenir le router à partir du contexte de la requete
        $routerContext = RouteContext::fromRequest($request);
        $router = $routerContext->getRouteParser();
        $id = $args['id_emission'];
        try {
            $podcastsDTO = $this->podcastService->GetPodcastByEmission($id);

            foreach ($podcastsDTO as $podcastDTO) {
                $podcasts [] = [
                    'id' => $podcastDTO->id,
                    'titre' => $podcastDTO->titre,
                    'description' => $podcastDTO->description,
                    'duree' => $podcastDTO->duree,
                    'date' => $podcastDTO->date,
                    'audio' => $podcastDTO->audio,
                    'photo' => $podcastDTO->photo,
                    'links' => [
                        'self' => [
                            "href" => $router->urlFor('podcast.show', ['id_podcast' => $podcastDTO->id]),
                        ],
                        'emission' => [
                            "href" => $router->urlFor('emission.show', ['id_emission' => $podcastDTO->idEmission]),
                        ],
                        'invite' => [
                            "href" => $router->urlFor('podcast.invites', ['id' => $podcastDTO->id])
                        ]
                    ]
                ];
            }
            $data = [
                'type' => 'resource',
                'podcasts' => $podcasts
            ];
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (PodcastNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
    }
}