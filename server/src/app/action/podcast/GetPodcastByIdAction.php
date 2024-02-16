<?php

namespace radio\net\app\action\podcast;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\podcast\iPodcastService;
use radio\net\domaine\service\podcast\PodcastNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class GetPodcastByIdAction extends Action
{
    private iPodcastService $servicePodcast;
    public function __construct(iPodcastService $service_podcast)
    {
        $this->servicePodcast = $service_podcast;
    }

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        try {
            // obtenir le router à partir du contexte de la requete
            $routerContext = RouteContext::fromRequest($request);
            $router = $routerContext->getRouteParser();

            $id = $args['id_podcast'] ?? 0;
            $podcastDTO = $this->servicePodcast->getPodcastById($id);

            $podcast = [
                'id' => $podcastDTO->id,
                'titre' => $podcastDTO->titre,
                'description' => $podcastDTO->description,
                'duree' => $podcastDTO->duree,
                'date' => $podcastDTO->date,
                'audio' => $podcastDTO->audio,
                'photo' => $podcastDTO->photo,
                'links' => [
                    'self' => [
                        'href' => $router->urlFor('podcast.show', ['id_podcast' => $podcastDTO->id]),
                    ],
                    'emission' => [
                        'href' => $router->urlFor('emission.show', ['id_emission' => $podcastDTO->idEmission])
                    ],
                    'invite' => [
                        "href" => $router->urlFor('podcast.invites', ['id' => $podcastDTO->id])
                    ]
                ],
            ];
            // mise en forme des données pour le json
            // 'emission' => $router ... -> renvoie une uri vers laquelle il faut se diriger pour obtenir toutes les emissions
            $data = [
                'type' => 'resource',
                'podcast' => $podcast
            ];

            // json_encode convertit les données en chaine JSON
            $response->getBody()->write(json_encode($data));

            //retourne la réponse avec un code 200
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (PodcastNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
    }
}
