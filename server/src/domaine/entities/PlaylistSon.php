<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;

class PlaylistSon extends Model
{
    public $connection = 'radio';
    protected $table = 'PlaylistSon';
    protected $fillable = [
        'idPlaylist',
        'idSon'
    ];

}