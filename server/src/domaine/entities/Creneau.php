<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;
use radio\net\domaine\dto\CreneauDTO;

class Creneau extends Model
{
    public $connection = 'radio';
    protected $table = 'creneau';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'jourSemaine',
        'heureDeDepart',
        'heureDeFin',
        'emissionId'
    ];

    public function toDTO () {
        return new CreneauDTO(
            $this->id,
            $this->jourSemaine,
            $this->heureDeDepart,
            $this->heureDeFin,
            $this->emissionId
        );
    }
}