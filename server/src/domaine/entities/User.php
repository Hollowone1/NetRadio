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
        'username',
        'role',
        'refresh_token',
        'refresh_token_expiration_date',
        'reset_password_token',
        'reset_password_token_expiration_date'
    ];

    public function toDTO() {
        $user = new UserDTO($this->email);
        $user->password = $this->password;
        $user->username = $this->username;
        $user->role = $this->role;
        $user->refresh_token = $this->refresh_token;
        $user->refresh_token_expiration_date = $this->refresh_token_expiration_date;
        $user->reset_password_token = $this->reset_password_token;
        $user->reset_password_token_expiration_date = $this->reset_password_token_expiration_date;
        return $user;
    }
}