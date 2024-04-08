<?php

namespace radio\net\domaine\dto;

class SonDTO
{
    public int $id;
    public string $titre;
    public string $nomArtiste;
    public string $audio;

    public function __construct ($p_titre, $p_nomArtiste, $p_audio) {
        $this->titre = $p_titre;
        $this->nomArtiste = $p_nomArtiste;
        $this->audio = $p_audio;
    }
    public function toArray () {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'nomArtiste' => $this->nomArtiste,
            'audio' => $this->audio
        ];
    }
}