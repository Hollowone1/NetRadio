<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;
use radio\net\domaine\dto\UserDTO;

class User extends Model
{
    public $connection= 'radio' ;
    protected $table = 'User';
    protected $primaryKey = 'email';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'email',
        'password',
        'prenom',
        'nom',
        'role',
        'refresh_token',
        'refresh_token_expiration_date',
        'reset_password_token',
        'reset_password_token_expiration_date'
    ];

    public function toDTO() {
        return new UserDTO($this->email, $this->password, $this->prenom, $this->nom, $this->role, $this->refresh_token, $this->refresh_token_expiration_date, $this->reset_password_token, $this->reset_password_token_expiration_date);
    }
}