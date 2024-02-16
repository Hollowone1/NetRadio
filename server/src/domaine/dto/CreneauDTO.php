<?php

namespace radio\net\domaine\dto;

class CreneauDTO
{
    public int $id;
    public int $joutSemaine;
    public string $heureDeDepart;
    public string $heureDeFin;
    public int $emissionid;

    public function __construct($p_id, $p_jourSemaine, $p_heureDepart, $p_heureFin, $p_emission) {
        $this->id = $p_id;
        $this->joutSemaine = $p_jourSemaine;
        $this->heureDeDepart = $p_heureDepart;
        $this->heureDeFin = $p_heureFin;
        $this->emissionid = $p_emission;
    }

    public function toArray () {
        return [
            'id' => $this->id,
            'jourSemaine' => $this->joutSemaine,
            'heureDepart' => $this->heureDeDepart,
            'heureFin' => $this->heureDeFin,
            'emission' => $this->emissionid
        ];
    }
}