<?php

namespace radio\net\domaine\entities;

use Illuminate\Database\Eloquent\Model;
use radio\net\domaine\dto\PodcastDTO;

class Podcast extends Model
{
    public $connection = 'radio';
    protected $primaryKey='id';
    protected $table='Podcast';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'titre',
        'description',
        'duree',
        'date',
        'audio',
        'photo',
        'emission_id'
    ];
    public function emission () {
        return $this->belongsTo(Emission::class, 'emission_id')->first();
    }

    public function toDTO () {
        $podcastDTO = new PodcastDTO($this->titre, $this->description, $this->duree, $this->date, $this->audio, $this->photo, $this->emission_id);
        $podcastDTO->setId($this->id);
        return $podcastDTO;
    }
}