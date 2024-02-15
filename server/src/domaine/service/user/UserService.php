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
                $usersDTO [] = $user->toDTO()->toArray();
            }
            return $usersDTO;
        } catch (UserNotFoundException $e) {
            throw new UserNotFoundException("User not found");
        }
    }

    public function GetInfoUserByMail ($mail) {
        try {
            $user = User::where('email', $mail)->first();
            return $user->toDTO();
        } catch (\Exception $e) {
            throw new UserNotFoundException("User not found");
        }
    }
}