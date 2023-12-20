<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    public $connection = 'id';
    protected $table = 'Playlist';
    protected $fillable = [
        'id',
        'nom',
        'description',
        'emailUser'
    ];

    public function toDTO () {

    }

}