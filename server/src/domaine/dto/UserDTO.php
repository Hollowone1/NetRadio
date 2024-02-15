<?php

namespace radio\net\domaine\dto;

class UserDTO
{
    public string $email;
    public string $password;
    public string $username;
    public ?string $prenom;
    public ?string $nom;
    public string $role;
    public ?string $refresh_token;
    public ?string $refresh_token_expiration_date;
    public ?string $reset_password_token;
    public ?string $reset_password_token_expiration_date;

    public function __construct ($p_email){
        $this->email = $p_email;
    }
    public function toArray () {
        return [
            'email' => $this->email,
            'username' => $this->username,
            'role' => $this->role,
            'prenom' => $this->prenom,
            'nom' => $this->nom
        ];
    }
}