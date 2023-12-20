<?php

namespace radio\net\domaine\dto;

use radio\net\domaine\entities\User;

class EmissionDTO extends DTO
{
    public int $id;
    public string $titre;
    public string $description;
    public string $theme;
    public string $photo;
    public User $user;

    public function __construct ($p_id, $p_titre, $p_description, $p_theme, $p_photo, $p_user) {
        $this->id = $p_id;
        $this->titre = $p_titre;
        $this->description = $p_description;
        $this->theme = $p_theme;
        $this->photo = $p_photo;
        $this->user = $p_user;
    }

    public function toArray () {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description'=> $this->description,
            'theme' => $this->theme,
            'photo' => $this->photo,
            'user' => $this->user
        ];
    }
}