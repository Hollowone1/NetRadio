<?php

namespace radio\net\app\action\auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\domaine\dto\CredentialsDTO;
use radio\net\domaine\service\auth\AuthServiceCredentialsException;
use radio\net\domaine\service\auth\AuthServiceInterface;
use radio\net\app\action\Action;
use Slim\Exception\HttpBadRequestException;

class SignupAction extends Action
{
    private AuthServiceInterface $serviceAuth;

    public function __construct(AuthServiceInterface $serviceAuth)
    {
        $this->serviceAuth = $serviceAuth;
    }

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Récupérez les données JSON du corps de la requête
        $data = $request->getParsedBody();

        if (!isset($data['email']) || !isset($data['password']) || !isset($data['username']) || !isset($data['nom']) || !isset($data['prenom'])) {
            throw new HttpBadRequestException($request, 'Données invalides');
        }

        // Validation de l'email avec une expression régulière
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new HttpBadRequestException($request, 'Adresse email invalide');
        }

        if (!filter_var($data['prenom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) || !filter_var($data['nom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            throw new HttpBadRequestException($request, 'prenom ou nom à des caractères non valide');
        }

        // Vérifier si le mot de passe contient au moins 8 caractères, une majuscule
        if (!preg_match('/^(?=.*[A-Z]).{8,}$/', $data['password'])) {
            throw new HttpBadRequestException($request, 'Le mot de passe doit contenir au moins 8 caractères avec au moins une majuscule');
        }

        $email = htmlspecialchars($data['email']);
        $password = $data['password'];
        $username = htmlspecialchars($data['username']);
        $nom = $data['nom'];
        $prenom = $data['prenom'];

        try {
            $credentialsDTO = new CredentialsDTO($email, $password);
            $credentialsDTO->username = $username;
            $credentialsDTO->nom = $nom;
            $credentialsDTO->prenom = $prenom;
            $this->serviceAuth->signup($credentialsDTO);
            $response->getBody()->write(json_encode(['message' => 'Inscription réussie']));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json; charset=utf-8');
        } catch (AuthServiceCredentialsException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json; charset=utf-8');
        }
    }
}
