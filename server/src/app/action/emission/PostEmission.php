<?php

namespace radio\net\app\action\emission;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\dto\EmissionDTO;
use radio\net\domaine\service\emission\iEmissionService;
use Slim\Routing\RouteContext;

class PostEmission extends Action
{
    public iEmissionService $emissionService;

    public function __construct(iEmissionService $emissionService) {
        $this->emissionService = $emissionService;
    }
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $routerContext = RouteContext::fromRequest($request);
        $router = $routerContext->getRouteParser();
        $data = json_decode($request->getBody()->getContents(), true);
        $emissionDTO = new EmissionDTO(
            $data['titre'],
            $data['description'],
            $data['theme'],
            $data['photo'],
            $data['onDirect'],
            $data['user']
        );

        $emission = $this->emissionService->postEmission($emissionDTO);

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

        $data = [
            'type' => 'resource',
            'podcasts' => $dataJson
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

    }
}