<?php

namespace radio\net\domaine\service\son;

use radio\net\domaine\entities\Son;

class SonService implements iSonService
{

    /**
     * @throws SonNotFoundException
     */
    public function getSonById($id)
    {
        try {
            $son = Son::findById($id);
            if ($son == null) {
                throw new SonNotFoundException();
            }
            return $son;
        } catch (SonNotFoundException $e) {
            throw $e;
        }
    }

    /**
     * @throws SonNotFoundException
     */
    public function getSonsByPlaylistId($playlistId)
    {
        try {
            $son = Son::findByPlaylistId($playlistId);
            if ($son == null) {
                throw new SonNotFoundException();
            }
            return $son;
        } catch (SonNotFoundException $e) {
            throw $e;
        }
    }

    /**
     * @throws SonNotFoundException
     */
    public function getAllSons()
    {
        try {
            $son = Son::all();
            if ($son == null) {
                throw new SonNotFoundException();
            }
            return $son;
        } catch (SonNotFoundException $e) {
            throw $e;
        }
    }

}