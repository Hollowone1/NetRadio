<?php

namespace radio\net\domaine\dto;

use radio\net\domaine\entities\User;

class PlaylistDTO
{
    public int $id;
    public string $nom;
    public string $description;
    public User $user;

    public function __construct ($p_id, $p_nom, $p_description, $p_user) {
        $this->id = $p_id;
        $this->nom = $p_nom;
        $this->description = $p_description;
        $this->user = $p_user;
    }

    public function toArray () {
        return [
          'id' => $this->id,
          'nom' => $this->nom,
          'description' => $this->description,
          'user' => $this->user
        ];
    }

}