<?php

namespace radio\net\app\service\podcast;
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
}