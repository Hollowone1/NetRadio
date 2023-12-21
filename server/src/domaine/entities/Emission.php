<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;
use radio\net\domaine\dto\EmissionDTO;

class Emission extends Model
{

    public $connection = 'radio';
    protected $table = 'Emission';
    protected $fillable = [
        'id',
        'titre',
        'description',
        'theme',
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
        $userDTO = $this->user()->toDTO();
        return new EmissionDTO(
            $this->id,
            $this->titre,
            $this->description,
            $this->theme,
            $this->photo,
            $userDTO
        );
    }
}