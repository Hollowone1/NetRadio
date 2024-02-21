<?php

namespace radio\net\app\action\emission;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\emission\EmissionNotFoundException;
use radio\net\domaine\service\emission\iEmissionService;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class GetEmissionById extends Action
{
    public iEmissionService $emissionService;

    public function __construct(iEmissionService $emissionService) {
        $this->emissionService = $emissionService;
    }

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id_emission'];
        try {
            $router = RouteContext::fromRequest($request);
            $route = $router->getRouteParser();

            $emission = $this->emissionService->getEmissionById($id);
            $emissionResponse = [
                'id' => $emission->id,
                'titre' => $emission->titre,
                'description'=> $emission->description,
                'theme' => $emission->theme,
                'photo' => $emission->photo,
                'links' => [
                    'self' => [
                        "href" => $route->urlFor('emission.show', ['id_emission' => $emission->id])
                    ],
                    'users' => [
                        "href" => $route->urlFor('emission.presentateur', ['id_emission' => $emission->id])
                    ],
                    'creneaux' => [
                        "href" => $route->urlFor('creneaux.emission', ['id_emission' => $emission->id])
                    ],
                    'podcasts' => [
                        "href" => $route->urlFor('podcasts.emission', ['id_emission' => $emission->id])
                    ]
                ],
            ];
            $data = [
                'type' => 'resource',
                'emission' => $emissionResponse
            ];
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (EmissionNotFoundException $e) {
            throw new HttpNotFoundException($request ,$e->getMessage());
        }
    }
}