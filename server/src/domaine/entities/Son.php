<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;

class Son extends Model
{
    public $connection = 'radio';
    protected $table = 'Son';
    protected $fillable = [
        'id',
        'titre',
        'nomArtiste',
        'audio'
    ];

    public function toDTO() {

    }
}