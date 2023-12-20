<?php

namespace radio\net\domaine\service\user;

use radio\net\domaine\entities\User;

class UserService implements iUserService
{
    public function GetInfoUserById ($id) {
        try {
            $user = User::find($id);
            return $user->toDTO();
        } catch (\Exception $e) {
            throw new UserNotFoundException("User not found");
        }
    }
}