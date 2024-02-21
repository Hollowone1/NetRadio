<?php

namespace radio\net\domaine\service\user;

use radio\net\domaine\dto\UserDTO;
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

    public function PutUser($userDTO) : UserDTO
    {
        try {
            $data = [
                "email" => $userDTO->email,
                "role" => $userDTO->role
            ];

            $affected = User::where('email', $userDTO->email)->update($data);

            if ($affected > 0) {
                // Si au moins une ligne a été mise à jour, vous pouvez récupérer le podcast mis à jour
                $user = User::find($userDTO->email);
                return $user->toDTO();
            } else {
                // Si aucun enregistrement n'a été mis à jour, lancez une exception
                throw new UserNotFoundException("Vous avez déjà modifié cette utilisateur");
            }
        } catch (\Exception $e) {
            throw new UserNotFoundException("Vous avez déjà modifié cette utilisateur");
        }
    }
}