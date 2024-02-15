<?php

namespace radio\net\domaine\dto;

class UserDTO
{
    public string $email;
    public string $password;
    public string $username;
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
            'password' => $this->password,
            'username' => $this->username,
            'role' => $this->role,
            'refresh_token' => $this->refresh_token,
            'refresh_token_expiration_date' => $this->refresh_token_expiration_date,
            'reset_password_token' => $this->reset_password_token,
            'reset_password_token_expiration_date' => $this->reset_password_token_expiration_date
        ];
    }
}