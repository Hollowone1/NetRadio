<?php

namespace radio\net\app\action\user;

use radio\net\app\action\Action;
use radio\net\domaine\dto\PodcastDTO;
use radio\net\domaine\dto\UserDTO;
use radio\net\domaine\service\user\iUserService;
use Slim\Routing\RouteContext;

class PutUser extends Action
{
    private iUserService $service;

    public function __construct ($userService) {
        $this->service = $userService;
    }

    function __invoke(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args)
    {
        $routeContext = RouteContext::fromRequest($request);
        $router = $routeContext->getRouteParser();
        $mail = $args['email'];
        $data = json_decode($request->getBody()->getContents(), true);

        $userDTO = new UserDTO($mail);
        $userDTO->role = $data['role'];

        $user = $this->service->putUser($userDTO)->toArray();

        $data = [
            'type' => 'resource',
            'podcasts' => $user
        ];

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}