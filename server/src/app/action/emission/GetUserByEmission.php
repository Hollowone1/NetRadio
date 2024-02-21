<?php

namespace radio\net\app\action\emission;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\emission\iEmissionService;
use Slim\Routing\RouteContext;

class GetUserByEmission extends Action
{
    private iEmissionService $emissionService;

    public function __construct ($emission) {
        $this->emissionService = $emission;
    }

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        // obtenir le router à partir du contexte de la requete
        $routerContext = RouteContext::fromRequest($request);
        $router = $routerContext->getRouteParser();
        $id = $args['id_emission'];
        $users= $this->emissionService->getUserByEmission($id);
        $usersRep = [];
        foreach ($users as $user) {
            $usersRep [] = [
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'links' => [
                    'self' => [
                        "href" => $router->urlFor('user.show', ['email' => $user->email]),
                    ]
                ],
            ];
        }

        $data = [
            'type' => 'resource',
            'user' => $usersRep
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}