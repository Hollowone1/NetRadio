<?php

namespace radio\net\app\action\creneau;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\creneau\CreneauNotFoundException;
use radio\net\domaine\service\creneau\CreneauService;
use radio\net\domaine\service\creneau\iCreneauService;
use Slim\Routing\RouteContext;

class GetCreneauById extends Action
{
    public iCreneauService $creneauService;

    public function __construct(CreneauService $creneauService) {
        $this->creneauService = $creneauService;
    }

    /**
     * @throws CreneauNotFoundException
     */
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        // obtenir le router à partir du contexte de la requete
        $routerContext = RouteContext::fromRequest($request);
        $router = $routerContext->getRouteParser();

        $id = $args['id'];
        $creneau = $this->creneauService->getCreneauById($id);

        $creneaux = [
            'id' => $creneau->id,
            'jourSemaine' => $creneau->joutSemaine,
            'heureDepart' => $creneau->heureDeDepart,
            'heureFin' => $creneau->heureDeFin,
            'links' => [
                'self' => [
                    "href" => $router->urlFor('creneaux.show', ['id' => $creneau->id]),
                ],
                'emission' => [
                    "href" => $router->urlFor('emission.show', ['id_emission' => $creneau->emission_id]),
                ],
            ],
        ];
        $data = [
            'type' => 'resource',
            'creneau' => $creneaux
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}