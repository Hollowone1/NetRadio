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
                'user' => $route->urlFor('user.index', ['email' => $emission->user])
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