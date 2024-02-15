<?php

namespace radio\net\app\action\user;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\domaine\service\user\iUserService;
use radio\net\domaine\service\user\UserNotFoundException;
use Slim\Exception\HttpNotFoundException;

class GetUserAllInfo extends \radio\net\app\action\Action
{

    private iUserService $service;

    public function __construct ($userService) {
        $this->service = $userService;
    }
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        try {
            $users = $this->service->GetAllInfoUser();
            $data = [
                'type' => 'resource',
                'users' => $users
            ];
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (UserNotFoundException $e) {
            throw new HttpNotFoundException($request ,$e->getMessage());
        }
    }
}