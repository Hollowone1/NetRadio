<?php

namespace radio\net\domaine\service\creneau;

use Illuminate\Database\Eloquent\Collection;
use radio\net\domaine\entities\Creneau;

class CreneauService implements iCreneauService
{

    /**
     * @throws CreneauNotFoundException
     */
    public function getCreneauById($id)
        {
            $creneau = Creneau::find($id);
            if ($creneau == null) {
                throw new CreneauNotFoundException();
            }
            return $creneau;
        }

    /**
     * @throws CreneauNotFoundException
     */
    public function getAllCreneaux(): Collection
    {
        $creneaux = Creneau::all();
        if ($creneaux == null) {
            throw new CreneauNotFoundException();
        }
        return $creneaux;
    }
}