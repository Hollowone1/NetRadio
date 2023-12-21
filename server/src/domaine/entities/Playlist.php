<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;
use radio\net\domaine\dto\PlaylistDTO;

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
        return new PlaylistDTO(
            $this->id,
            $this->nom,
            $this->description,
            $this->emailUser
        );
    }

    public function sons() {
        return $this->belongsToMany(Son::class, 'PlaylistSon', 'idPlaylist', 'idSon');
    }

}