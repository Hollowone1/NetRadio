<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;
use radio\net\domaine\dto\CreneauDTO;

class Creneau extends Model
{
    public $connection = 'radio';
    protected $table = 'Creneau';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'jourSemaine',
        'heureDeDepart',
        'heureDeFin',
        'emission_id'
    ];

    public function toDTO () {
        return new CreneauDTO(
            $this->id,
            $this->jourSemaine,
            $this->heureDeDepart,
            $this->heureDeFin,
            $this->emission_id
        );
    }
}