<?php

namespace radio\net\domaine\service\emission;

use radio\net\domaine\entities\Emission;

class EmissionService implements iEmissionService
{
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
}