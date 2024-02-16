<?php

namespace radio\net\app\action\emission;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\emission\iEmissionService;
use Slim\Routing\RouteContext;

class GetCreneauByEmission extends Action
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
        $creneaux = $this->emissionService->getCreneauxByEmission($id);
        $creneauxRep = [];
        foreach ($creneaux as $creneau) {
            $creneauxRep [] = [
                'id' => $creneau->id,
                'jourSemaine' => $creneau->joutSemaine,
                'heureDepart' => $creneau->heureDeDepart,
                'heureFin' => $creneau->heureDeFin,
                'emission' => $creneau->emissionid,
                'links' => [
                    'self' => [
                        "href" => $router->urlFor('creneaux.show', ['id' => $creneau->id]),
                    ],
                    'emission' => [
                        "href" => $router->urlFor('emission.show', ['id_emission' => $creneau->emissionid]),
                    ],
                ],
            ];
        }

        $data = [
            'type' => 'resource',
            'creneau' => $creneauxRep
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}