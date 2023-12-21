<?php

namespace radio\net\domaine\service\emission;

use radio\net\domaine\entities\Emission;
use radio\net\domaine\entities\Podcast;

class EmissionService implements iEmissionService
{
    public function getEmissionById ($id) {
        try {
            $emission = Emission::where('id', $id)->first();
            return $emission->toDTO();
        } catch (EmissionNotFoundException $e) {
            throw new EmissionNotFoundException('Emission not found');
        }
    }
}