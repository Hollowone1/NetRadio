<?php

namespace radio\net\app\action\emission;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\dto\EmissionDTO;
use radio\net\domaine\service\emission\EmissionNotFoundException;
use radio\net\domaine\service\emission\iEmissionService;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class PutEmission extends Action
{

    public iEmissionService $emissionService;

    public function __construct(iEmissionService $emissionService) {
        $this->emissionService = $emissionService;
    }

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        try {
            $routeContext = RouteContext::fromRequest($request);
            $router = $routeContext->getRouteParser();

            //récupération du podcast avec l'id
            $id = $args['id'];
            $data = json_decode($request->getBody()->getContents(), true);
            $emissionDTO = new EmissionDTO(
                $data['titre'],
                $data['description'],
                $data['theme'],
                $data['photo'],
                $data['onDirect'],
                $data['user']
            );
            $emissionDTO->id = $id;

            //modification du podcast
            $emission = $this->emissionService->putEmission($emissionDTO);

            // les mettre sous la format json
            $dataJson = [
                'id' => $emission->id,
                'titre' => $emission->titre,
                'description'=> $emission->description,
                'onDirect' => $emission->onDirect,
                'theme' => $emission->theme,
                'photo' => $emission->photo,
                'links' => [
                    'self' => [
                        "href" => $router->urlFor('emission.show', ['id_emission' => $emission->id])
                    ],
                    'users' => [
                        "href" => $router->urlFor('user.show', ['email' => $emission->user])
                    ],
                    'creneaux' => [
                        "href" => $router->urlFor('creneaux.emission', ['id_emission' => $emission->id])
                    ],
                    'podcasts' => [
                        "href" => $router->urlFor('podcasts.emission', ['id_emission' => $emission->id])
                    ]
                ]
            ];

            //envoie des données
            $data = [
                'type' => 'resource',
                'podcasts' => $dataJson
            ];

            $response->getBody()->write(json_encode($data));
            return $response;
        } catch (EmissionNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

    }
}