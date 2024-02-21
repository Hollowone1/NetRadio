<?php

namespace radio\net\domaine\provider;

interface AuthProviderInterface
{
    public function checkCredentials(string $email, string $pass): void;

    public function checkToken(string $token): void;

    public function register(string $email, string $pass, string $username, string $nom, string $prenom): void;

    public function getAuthenticatedUser(): array;
}
