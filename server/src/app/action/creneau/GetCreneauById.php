<?php

namespace radio\net\app\action\creneau;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\creneau\CreneauNotFoundException;
use radio\net\domaine\service\creneau\CreneauService;
use radio\net\domaine\service\creneau\iCreneauService;

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
        $id = $args['id'];
        $creneau = $this->creneauService->getCreneauById($id);
        $data = [
            'type' => 'resource',
            'creneau' => $creneau
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}