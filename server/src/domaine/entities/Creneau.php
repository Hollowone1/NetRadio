<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{
    public $connection = 'radio';
    protected $table = 'creneau';
    protected $fillable = [
        'id',
        'jourSemaine',
        'heureDeDepart',
        'heureDeFin',
        'emissionId'
    ];

    public function toDTO () {

    }
}