<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;
use radio\net\domaine\dto\EmissionDTO;

class Emission extends Model
{

    public $connection = 'radio';
    protected $table = 'Emission';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'titre',
        'description',
        'theme',
        'onDirect',
        'photo',
        'user_mail'
    ];

    public function podcasts () {
        return $this->hasMany(Podcast::class, 'emission_id');
    }

    public function user () {
        return $this->belongsTo(User::class, 'user_mail')->first();
    }


    public function toDTO () {
        return new EmissionDTO(
            $this->id,
            $this->titre,
            $this->description,
            $this->theme,
            $this->photo,
            $this->onDirect,
            $this->user_mail
        );
    }
}