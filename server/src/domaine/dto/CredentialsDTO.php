<?php

namespace radio\net\domaine\dto;

class CredentialsDTO extends DTO
{
    public string $email;
    public string $password;
    public string $username;
    public string $nom;
    public string $prenom;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}
