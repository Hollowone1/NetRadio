<?php

namespace radio\net\domaine\service\emission;

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
}