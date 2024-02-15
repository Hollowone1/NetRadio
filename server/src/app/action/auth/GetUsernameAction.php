<?php

namespace radio\net\app\action\auth;

use Exception;
use radio\net\domaine\service\auth\AuthServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;

class GetUsernameAction extends Action
{
    private AuthServiceInterface $serviceAuth;

    public function __construct(AuthServiceInterface $serviceAuth)
    {
        $this->serviceAuth = $serviceAuth;
    }

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $data = $request->getQueryParams();
            if (!isset($data['id_user'])) {
                $response->getBody()->write(json_encode(['error' => 'id_user manquant']));
                return $response->withStatus(400);
            }

            $username = $this->serviceAuth->getUsername($data['id_user']);

            $donnees = [
                'username' => $username
            ];

            $response->getBody()->write(json_encode($donnees));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json;charset=utf-8');

        } catch (Exception $e) {
            $response->getBody()->write(json_encode(['error' => 'Erreur interne' . $e->getMessage()]));
            return $response->withStatus(500);
        }
    }
}
