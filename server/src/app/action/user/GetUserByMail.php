<?php

namespace radio\net\app\action\user;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\user\iUserService;
use radio\net\domaine\service\user\UserNotFoundException;
use Slim\Exception\HttpNotFoundException;

class GetUserByMail extends Action
{
    private iUserService $userService;
    public function __construct($userService) {
        $this->userService = $userService;
    }
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $email = $args['email'];
        try {
            $user = $this->userService->GetInfoUserByMail($email);
            $data = [
                'type' => 'resource',
                'user' => $user
            ];
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (UserNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
    }
}