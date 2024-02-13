<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;

class PlaylistSon extends Model
{
    public $connection = 'radio';
    protected $table = 'PlaylistSon';
    public $timestamps = false;
    protected $fillable = [
        'idPlaylist',
        'idSon'
    ];

}