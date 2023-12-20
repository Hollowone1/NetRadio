<?php

namespace radio\net\domaine\service\podcast;
use radio\net\domaine\entities\Podcast;

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
    }