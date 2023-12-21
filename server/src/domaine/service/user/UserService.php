<?php

namespace radio\net\domaine\service\user;

use radio\net\domaine\entities\User;

class UserService implements iUserService
{

    public function GetAllInfoUser () {
        try {
            $users = User::all();
            $usersDTO = [];
            foreach ($users as $user) {
                $usersDTO [] = $user->toDTO();
            }
            return $usersDTO;
        } catch (UserNotFoundException $e) {
            throw new UserNotFoundException("User not found");
        }
    }

    public function GetInfoUserById ($id) {
        try {
            $user = User::find($id);
            return $user->toDTO();
        } catch (\Exception $e) {
            throw new UserNotFoundException("User not found");
        }
    }
}