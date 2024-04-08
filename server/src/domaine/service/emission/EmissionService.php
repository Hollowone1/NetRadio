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

    public function getUserByEmission ($id) {
        try {
            $userDTO = [];
            $users = Emission::findOrFail($id)->user();
            foreach ($users as $user) {
                $userDTO [] = $user;
            }
            return $userDTO;
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

    public function putEmission ($emissionDTO) : EmissionDTO {
        try {
            //vérification des données qui viennent d'une requete put
            $titre = filter_var($emissionDTO->titre, FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($emissionDTO->description, FILTER_SANITIZE_SPECIAL_CHARS);
            $onDirect = $emissionDTO->onDirect;
            $theme = $emissionDTO->theme;
            $photo = filter_var($emissionDTO->photo,FILTER_SANITIZE_SPECIAL_CHARS);
            $user = filter_var($emissionDTO->user, FILTER_VALIDATE_EMAIL);

            $data = [
                "id" => $emissionDTO->id,
                "titre" => $titre,
                "description" => $description,
                "onDirect" => $onDirect,
                "theme" => $theme,
                "photo" => $photo,
                "user_mail" => $user,
            ];

            $affected = Emission::where('id', $emissionDTO->id)->update($data);

            if ($affected > 0) {
                // Si au moins une ligne a été mise à jour, vous pouvez récupérer le podcast mis à jour
                $emission = Emission::find($emissionDTO->id);
                return $emission->toDTO();
            } else {
                // Si aucun enregistrement n'a été mis à jour, lancez une exception
                throw new EmissionNotFoundException("Emission not found");
            }

        } catch (\Exception) {
            throw new EmissionNotFoundException("Les champs sont les mêmes. Aucune modification n'a été effectuée.");
        }
    }
}