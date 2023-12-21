<?php

namespace radio\net\domaine\service\podcast;
use radio\net\domaine\entities\Podcast;
use radio\net\domaine\service\emission\EmissionNotFoundException;

class PodcastService implements iPodcastService
{
    public function getPodcastById (int $id) {
        try {
            $podcast = Podcast::find($id);
            $podcastDTO = $podcast->toDTO();
        } catch (\Exception $e) {
            throw new PodcastNotFoundException('Podcast not found');
        }
        return $podcastDTO;
    }

    public function GetAllPodcast () {
        try {
            $podcasts = Podcast::all();
            $podcastsDTO = [];
            foreach ($podcasts as $podcast) {
                $podcastsDTO [] = $podcast->toDTO();
            }
            return $podcastsDTO;
        } catch (\Exception) {
            throw new PodcastNotFoundException("Podcasts not found");
        }
    }
    public function GetPodcastByDate () : array {
        try {
            $podcasts = Podcast::orderBy('date', 'desc')->get();
            $podcastsDTO = [];
            foreach ($podcasts as $podcast) {
                $podcastsDTO [] = $podcast->toDTO();
            }
            return $podcastsDTO;
        } catch (\Exception) {
            throw new PodcastNotFoundException("Podcast not found");
        }
    }

    public function GetPodcastByEmission ($id_emission) {
        try {
            $podcasts = Podcast::where('emission_id' ,$id_emission)->get();
            $podcastDTO = [];
            foreach ($podcasts as $podcast) {
                $podcastDTO [] = $podcast->toDTO();
            }
            return $podcastDTO;
        } catch (\Exception) {
            throw new EmissionNotFoundException("Emission not found");
        }
    }
}