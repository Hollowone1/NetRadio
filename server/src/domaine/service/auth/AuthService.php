<?php

namespace radio\net\domaine\service\auth;

use Psr\Log\LoggerInterface;
use radio\net\domaine\dto\CredentialsDTO;
use radio\net\domaine\dto\TokenDTO;
use radio\net\domaine\dto\UserDTO;
use radio\net\domaine\manager\JwtManagerExpiredTokenException;
use radio\net\domaine\manager\JwtManagerInterface;
use radio\net\domaine\manager\JwtManagerInvalidTokenException;
use radio\net\domaine\provider\AuthProviderInterface;
use radio\net\domaine\provider\AuthProviderInvalidCredentialsException;
use radio\net\domaine\provider\AuthProviderInvalidTokenException;

class AuthService implements AuthServiceInterface
{
    private JwtManagerInterface $jwtManager;
    private AuthProviderInterface $authProvider;
    private LoggerInterface $logger;

    public function __construct(JwtManagerInterface $jwtManager, AuthProviderInterface $authProvider, LoggerInterface $logger)
    {
        $this->jwtManager = $jwtManager;
        $this->authProvider = $authProvider;
        $this->logger = $logger;
    }

    /**
     * @throws AuthServiceCredentialsException
     */
    public function signup(CredentialsDTO $c)
    {
        try {
            $this->authProvider->register($c->email, $c->password, $c->username, $c->nom, $c->prenom);
        } catch (AuthProviderInvalidCredentialsException $e) {
            throw new AuthServiceCredentialsException($e->getMessage());
        }
    }

    /**
     * @throws AuthServiceCredentialsException
     */
    public function signin(CredentialsDTO $c): TokenDTO
    {
        try {
            $this->authProvider->checkCredentials($c->email, $c->password);
        } catch (AuthProviderInvalidCredentialsException) {
            throw new AuthServiceCredentialsException("Invalid email or password.");
        }
        $user = $this->authProvider->getAuthenticatedUser();

        return new TokenDTO($this->jwtManager->create($user), $user['refresh_token']);
    }

    /**
     * @throws AuthServiceInvalidTokenException
     * @throws AuthServiceExpiredTokenException
     */
    public function validate(TokenDTO $t): UserDTO
    {
        try {
            $payload = $this->jwtManager->validate($t->access_token);
        } catch (JwtManagerExpiredTokenException) {
            throw new AuthServiceExpiredTokenException("Expired token");
        } catch (JwtManagerInvalidTokenException) {
            $this->logger->warning('failed jwt validation');
            throw new AuthServiceInvalidTokenException("Invalid token");
        }
        $userDTO = new UserDTO($payload['email']);
        $userDTO->username = $payload['username'];
        $userDTO->refresh_token = $payload['refresh_token'];
        return $userDTO;
    }

    /**
     * @throws AuthServiceInvalidTokenException
     */
    public function refresh(TokenDTO $t): TokenDTO
    {
        try {
            $this->authProvider->checkToken($t->refresh_token);
        } catch (AuthProviderInvalidTokenException $e) {
            $this->logger->warning('Failed jwt refresh because of invalid refresh token');
            throw new AuthServiceInvalidTokenException($e->getMessage());
        }
        $user = $this->authProvider->getAuthenticatedUser();

        return new TokenDTO($this->jwtManager->create($user), $user['refresh_token']);
    }

    //obtenir le username avec l'email du User
    public function getUsername(string $email): string
    {
        return User::where('email', $email)->first()->username;
    }
}
