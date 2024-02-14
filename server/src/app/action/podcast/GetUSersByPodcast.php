<?php

namespace radio\net\app\action\podcast;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\podcast\iPodcastService;
use radio\net\domaine\service\podcast\PodcastNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class GetUSersByPodcast extends Action
{
    private iPodcastService $servicePodcast;

    public function __construct(iPodcastService $service_podcast)
    {
        $this->servicePodcast = $service_podcast;
    }
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
            $id = $args['id'];

            // obtenir le router à partir du contexte de la requete
            $routerContext = RouteContext::fromRequest($request);
            $router = $routerContext->getRouteParser();

            // récuperation de tous les podcasts
            $podcastsDTO = [];

            $usersDTO = $this->servicePodcast->getUsersByPodcast($id);
            $users = [];
            foreach ($usersDTO as $user) {
                $users [] = [
                    'email' => $user->email,
                    'prenom' => $user->prenom,
                    'nom' => $user->nom
                ];
            }
            // mise en forme des données pour le json
            // 'emission' => $router ... -> renvoie une uri vers laquelle il faut se diriger pour obtenir toutes les emissions
            $data = [
                'type' => 'resource',
                'users' => $users
            ];

            // json_encode convertit les données en chaine JSON
            $response->getBody()->write(json_encode($data));

            //retourne la réponse avec un code 200
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

    }
}