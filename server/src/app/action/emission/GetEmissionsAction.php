<?php

namespace radio\net\app\action\emission;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\emission\EmissionNotFoundException;
use radio\net\domaine\service\emission\iEmissionService;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class GetEmissionsAction extends Action
{
    private iEmissionService $emissionService;

    public function __construct ($emission) {
        $this->emissionService = $emission;
    }
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        try {
            $router = RouteContext::fromRequest($request);
            $route = $router->getRouteParser();

            $queryParams = $request->getQueryParams();

            if (isset($queryParams['theme'])) {
                $emissions = $this->emissionService->getEmissionByTheme($queryParams['theme']);
            } else {
                $emissions = $this->emissionService->getEmissions();
            }

            foreach ($emissions as $emission) {
                $emissionsResponse [] = [
                    'id' => $emission->id,
                    'titre' => $emission->titre,
                    'description'=> $emission->description,
                    'theme' => $emission->theme,
                    'photo' => $emission->photo,
                    'onDirect' =>$emission->onDirect,
                    'links' => [
                        'self' => [
                            "href" => $route->urlFor('emission.show', ['id_emission' => $emission->id])
                        ],
                        'users' => [
                            "href" => $route->urlFor('user.show', ['email' => $emission->user])
                        ],
                        'creneaux' => [
                            "href" => $route->urlFor('creneaux.emission', ['id_emission' => $emission->id])
                        ],
                        'podcasts' => [
                            "href" => $route->urlFor('podcasts.emission', ['id_emission' => $emission->id])
                        ]
                    ],
                ];
            }

            $data = [
                'type' => 'resource',
                'emission' => $emissionsResponse
            ];
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (EmissionNotFoundException $e) {
            throw new HttpNotFoundException($request ,$e->getMessage());
        }
    }
}