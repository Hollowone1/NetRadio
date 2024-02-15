<?php

namespace radio\net\app\action\emission;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\domaine\service\emission\EmissionNotFoundException;
use radio\net\domaine\service\emission\iEmissionService;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class GetEmissionByTheme extends \radio\net\app\action\Action
{
    private iEmissionService $emissionService;

    public function __construct ($emission) {
        $this->emissionService = $emission;
    }
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $theme = $args['theme'];
        try {
            $router = RouteContext::fromRequest($request);
            $route = $router->getRouteParser();
            $emissionsResponse = [];
            $emissions = $this->emissionService->getEmissionByTheme($theme);
            foreach ($emissions as $emission) {
                $emissionsResponse [] = [
                    'id' => $emission->id,
                    'titre' => $emission->titre,
                    'description'=> $emission->description,
                    'theme' => $emission->theme,
                    'photo' => $emission->photo,
                    'onDirect' =>$emission->onDirect,
                    'user' => $route->urlFor('user.index', ['email' => $emission->user])
                ];
            }
            $data = [
                'type' => 'resource',
                'emissions' => $emissionsResponse
            ];
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (EmissionNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
    }
}