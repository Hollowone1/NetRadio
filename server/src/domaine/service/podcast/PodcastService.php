<?php

namespace radio\net\domaine\service\podcast;
use radio\net\domaine\dto\PodcastDTO;
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
            throw new PodcastNotFoundException("Podcast not found");
        }
    }

    public function putPodcast(PodcastDTO $podcastDTO)
    {
        try {
            //vérification des données qui viennent d'une requete put
            $id = $podcastDTO->getId();
            $titre = filter_var($podcastDTO->titre, FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($podcastDTO->description, FILTER_SANITIZE_SPECIAL_CHARS);
            $duree = $this->validateDuration($podcastDTO->duree);
            $date = $this->validateDate($podcastDTO->date);
            $audio = filter_var($podcastDTO->audio,FILTER_SANITIZE_SPECIAL_CHARS);
            $photo = filter_var($podcastDTO->photo,FILTER_SANITIZE_SPECIAL_CHARS);
            $idEmission = filter_var($podcastDTO->idEmission, FILTER_SANITIZE_NUMBER_INT);

            $data = [
                "id" => $id,
                "titre" => $titre,
                "description" => $description,
                "duree" => $duree,
                "date" => $date,
                "audio" => $audio,
                "photo" => $photo,
                "emission_id" => $idEmission
            ];

            $affected = Podcast::where('id', $id)->update($data);

            if ($affected > 0) {
                // Si au moins une ligne a été mise à jour, vous pouvez récupérer le podcast mis à jour
                $podcast = Podcast::find($id);
                return $podcast->toDTO();
            } else {
                // Si aucun enregistrement n'a été mis à jour, lancez une exception
                throw new PodcastNotFoundException("Vous avez déjà modifier ce podcast");
            }

        } catch (\Exception) {
            throw new PodcastNotFoundException("Vous avez déjà modifier ce podcast");
        }
    }

    public function postPodcast (PodcastDTO $podcastDTO)
    {
        try {
            $titre = filter_var($podcastDTO->titre, FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($podcastDTO->description, FILTER_SANITIZE_SPECIAL_CHARS);
            $duree = $this->validateDuration($podcastDTO->duree);
            $date = $this->validateDate($podcastDTO->date);
            $audio = filter_var($podcastDTO->audio,FILTER_SANITIZE_SPECIAL_CHARS);
            $photo = filter_var($podcastDTO->photo,FILTER_SANITIZE_SPECIAL_CHARS);
            $idEmission = filter_var($podcastDTO->idEmission, FILTER_SANITIZE_NUMBER_INT);

            $podcast = new Podcast();
            $podcast->titre = $titre;
            $podcast->description = $description;
            $podcast->duree = $duree;
            $podcast->date = $date;
            $podcast->audio = $audio;
            $podcast->photo = $photo;
            $podcast->emission_id = $idEmission;
            $podcast->save();

            return $podcast->toDTO();
        } catch (\Exception $exception) {
            throw new PodcastNotFoundException("Le podcast n'a pas pu se créer");
        }
    }

    // Validation de la date
    private function validateDate($date)
    {
        // Expression régulière pour valider le format YYYY-MM-DD
        $pattern = '/^\d{4}-\d{2}-\d{2}$/';

        // Vérifier si la date correspond au format attendu
        if (!preg_match($pattern, $date)) {
            throw new PodcastNotFoundException('Invalid date format. Expected format: YYYY-MM-DD');
        }

        // Retourner la date si la validation réussit
        return $date;
    }

    private function validateDuration($duration)
    {
        // Si la durée est au format hh:mm:ss
        if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $duration)) {
            throw new InvalidArgumentException('Invalid duration format');
        }

        // Retourner la durée si la validation réussit
        return $duration;
    }

}