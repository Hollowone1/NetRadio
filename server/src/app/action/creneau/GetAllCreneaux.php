<?php

namespace radio\net\app\action\creneau;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\creneau\CreneauNotFoundException;
use radio\net\domaine\service\creneau\CreneauService;
use radio\net\domaine\service\creneau\iCreneauService;
use Slim\Routing\RouteContext;

class GetAllCreneaux extends Action
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
        $router = RouteContext::fromRequest($request);
        $route = $router->getRouteParser();

        $creneaux = $this->creneauService->getAllCreneaux();
        $creneauDTO = [];
        foreach ($creneaux as $creneau) {
            $creneauDTO [] = [
                'id' => $creneau->id,
                'jourSemaine' => $creneau->joutSemaine,
                'heureDepart' => $creneau->heureDeDepart,
                'heureFin' => $creneau->heureDeFin,
                'links' => [
                    'self' => [
                        "href" => $route->urlFor('creneaux.show', ['id' => $creneau->id]),
                    ],
                    'emission' => [
                        "href" => $route->urlFor('emission.show', ['id_emission' => $creneau->emission_id]),
                    ],
                ],
            ];
        }

        $data = [
            'type' => 'resource',
            'creneaux' => $creneauDTO
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}