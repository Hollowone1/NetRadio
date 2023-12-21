<?php

namespace radio\net\app\action\podcast;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\GenerateAction;
use radio\net\domaine\service\podcast\PodcastNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class PodcastGenerator extends GenerateAction
{
    function generateActionResponse(ServerRequestInterface $request, ResponseInterface $response, $podcastsDTO) :ResponseInterface
    {
        try {
            // obtenir le router à partir du contexte dze la requete
            $routerContext = RouteContext::fromRequest($request);
            $router = $routerContext->getRouteParser();

            $podcasts = [];
            if (is_array($podcastsDTO)) {
                foreach ($podcastsDTO as $podcastsDTO) {
                    $podcasts [] = [
                        'id' => $podcastsDTO->id,
                        'titre' => $podcastsDTO->titre,
                        'description' => $podcastsDTO->description,
                        'duree' => $podcastsDTO->duree,
                        'date' => $podcastsDTO->date,
                        'audio' => $podcastsDTO->audio,
                        'photo' => $podcastsDTO->photo,
                        'emission' => $router->urlFor('emission', ['id_emission' => $podcastsDTO->idEmission])
                    ];
                }
                // mise en forme des données pour le json
                // 'emission' => $router ... -> renvoie une uri vers laquelle il faut se diriger pour obtenir toutes les emissions
                $data = [
                    'type' => 'resource',
                    'podcasts' => $podcasts
                ];
            } else {
                $podcasts = [
                    'id' => $podcastsDTO->id,
                    'titre' => $podcastsDTO->titre,
                    'description' => $podcastsDTO->description,
                    'duree' => $podcastsDTO->duree,
                    'date' => $podcastsDTO->date,
                    'audio' => $podcastsDTO->audio,
                    'photo' => $podcastsDTO->photo,
                    'emission' => $router->urlFor('emission', ['id_emission' => $podcastsDTO->idEmission])
                ];
                // mise en forme des données pour le json
                // 'emission' => $router ... -> renvoie une uri vers laquelle il faut se diriger pour obtenir toutes les emissions
                $data = [
                    'type' => 'resource',
                    'podcast' => $podcasts
                ];
            }




            // json_encode convertit les données en chaine JSON
            //écrit la chaîne json dans le corps de la réponse http
            $response->getBody()->write(json_encode($data));

            //retourne la réponse avec un code 200
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (PodcastNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
    }
}