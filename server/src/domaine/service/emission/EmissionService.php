<?php

namespace radio\net\domaine\service\emission;

use radio\net\domaine\dto\EmissionDTO;
use radio\net\domaine\entities\Emission;

class EmissionService implements iEmissionService
{
    public function getCreneauxByEmission ($id) {
        try {
            $creneauDTO = [];
            $creneaux = Emission::findOrFail($id)->creneaux();
            foreach ($creneaux as $creneau) {
                $creneauDTO [] = $creneau->toDTO();
            }
            return $creneauDTO;
        }catch (\Exception) {
            throw new EmissionNotFoundException('Emission not found');
        }
    }

    public function getEmissions () {
        try {
            $emissionsDTO = [];
            $emissions = Emission::all();
            foreach ($emissions as $emission) {
                $emissionsDTO [] = $emission->toDTO();
            }
            return $emissionsDTO;
        } catch (EmissionNotFoundException $e) {
            throw new EmissionNotFoundException('Emission not found');
        }
    }
    public function getEmissionById ($id) {
        try {
            $emission = Emission::where('id', $id)->first();
            return $emission->toDTO();
        } catch (EmissionNotFoundException $e) {
            throw new EmissionNotFoundException('Emission not found');
        }
    }

    public function getEmissionByTheme ($theme)
    {
        try {
            $emissionsDTO = [];
            $emissions = Emission::where('theme', $theme)->get();
            foreach ($emissions as $emission) {
                $emissionsDTO [] = $emission->toDTO();
            }
            return $emissionsDTO;
        } catch (EmissionNotFoundException $e) {
            throw new EmissionNotFoundException("Emission not found");
        }
    }

    public function postEmission($emissionDTO) : EmissionDTO
    {
            $titre = filter_var($emissionDTO->titre, FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($emissionDTO->description, FILTER_SANITIZE_SPECIAL_CHARS);
            $onDirect = $emissionDTO->onDirect;
            $theme = $emissionDTO->theme;
            $photo = filter_var($emissionDTO->photo,FILTER_SANITIZE_SPECIAL_CHARS);
            $user = filter_var($emissionDTO->user, FILTER_VALIDATE_EMAIL);

            $emission = new Emission();
            $emission->titre = $titre;
            $emission->description = $description;
            $emission->onDirect = $onDirect;
            $emission->theme = $theme;
            $emission->photo = $photo;
            $emission->user_mail = $user;
            $emission->save();

            return $emission->toDTO();
    }
}