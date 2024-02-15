<?php

namespace radio\net\domaine\service\auth;



use radio\net\domaine\dto\CredentialsDTO;
use radio\net\domaine\dto\TokenDTO;
use radio\net\domaine\dto\UserDTO;

interface AuthServiceInterface
{
    public function signup(CredentialsDTO $c);

    public function signin(CredentialsDTO $c): TokenDTO;

    public function validate(TokenDTO $t): UserDTO;

    public function refresh(TokenDTO $t): TokenDTO;

    public function getUsername(string $email): string;

}
