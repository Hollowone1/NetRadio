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
            $emissions = $this->emissionService->getEmissions();
            foreach ($emissions as $emission) {
                $emissionsResponse [] = [
                    'id' => $emission->id,
                    'titre' => $emission->titre,
                    'description'=> $emission->description,
                    'theme' => $emission->theme,
                    'photo' => $emission->photo,
                    'onDirect' =>$emission->onDirect,
                    'user' => $route->urlFor('/user/{id_user}[/]', ['id_user' => $emission->user])
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