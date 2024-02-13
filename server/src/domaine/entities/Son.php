<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;
use radio\net\domaine\dto\SonDTO;

class Son extends Model
{
    public $connection = 'radio';
    protected $primaryKey = 'id';
    protected $table = 'Son';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'titre',
        'nomArtiste',
        'audio'
    ];

    public function toDTO() {
        return new SonDTO(
            $this->id,
            $this->titre,
            $this->nomArtiste,
            $this->audio
        );
    }

    public function playlist() {
        return $this->belongsToMany(Playlist::class, 'PlaylistSon', 'idSon', 'idPlaylist');
    }

    public function findByPlaylistId($idPlaylist) {
        return $this->playlist()->where('idPlaylist', $idPlaylist)->get();
    }

}