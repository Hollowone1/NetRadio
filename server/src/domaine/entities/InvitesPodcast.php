<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;

class InvitesPodcast extends Model
{

    public $connection = 'radio';
    protected $table = 'InvitesPodcast';
    public $timestamps = false;
    protected $fillable = [
        'emailInvite',
        'idPodcast'
    ];

    public function toDTO () {

    }

}