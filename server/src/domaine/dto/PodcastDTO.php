<?php

namespace radio\net\domaine\dto;

class PodcastDTO extends DTO
{
    public ?int $id=null;
    public string $titre;
    public string $description;
    public string $duree;
    public string $date;
    public string $audio;
    public string $photo;
    public int $idEmission;

    public function __construct($p_titre, $p_description, $p_duree, $p_date, $p_audio, $p_photo, $p_emmission) {
        $this->titre = $p_titre;
        $this->description = $p_description;
        $this->duree = $p_duree;
        $this->date = $p_date;
        $this->audio = $p_audio;
        $this->photo = $p_photo;
        $this->idEmission = $p_emmission;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function toArray () : array {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'duree' => $this->duree,
            'date' => $this->date,
            'audio' => $this->audio,
            'photo' => $this->photo,
            'idEmission' => $this->idEmission
        ];
    }
}