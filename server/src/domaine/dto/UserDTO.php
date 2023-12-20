<?php

namespace radio\net\domaine\dto;

use function Symfony\Component\Translation\t;

class UserDTO
{
    public string $email;
    public string $password;
    public string $prenom;

    public string $nom;
    public string $role;
    public string $refresh_token;
    public string $refresh_token_expiration_date;
    public string $reset_password_token;
    public string $reset_password_token_expiration_date;

    public function __construct ($p_email, $p_password, $p_prenom, $p_nom, $p_role, $p_refresh_token, $p_refresh_token_expiration_date, $p_reset_password_token, $p_reset_password_token_expiration_date){
        $this->email = $p_email;
        $this->password = $p_password;
        $this->prenom = $p_prenom;
        $this->nom = $p_nom;
        $this->role = $p_role;
        $this->refresh_token = $p_refresh_token;
        $this->refresh_token_expiration_date = $p_refresh_token_expiration_date;
        $this->reset_password_token = $p_reset_password_token;
        $this->reset_password_token_expiration_date = $p_reset_password_token_expiration_date;

    }
    public function toArray () {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'role' => $this->role,
            'refresh_token' => $this->refresh_token,
            'refresh_token_expiration_date' => $this->refresh_token_expiration_date,
            'reset_password_token' => $this->reset_password_token,
            'reset_password_token_expiration_date' => $this->reset_password_token_expiration_date
        ];
    }
}