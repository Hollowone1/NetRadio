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
            $son = Son::find($id);
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
    public function getSonsByPlaylistId($playlistId): \Illuminate\Database\Eloquent\Collection
    {
        try {
            $son = Son::whereHas('playlist', function ($query) use ($playlistId) {
                $query->where('idPlaylist', '=', $playlistId);
            })->get();
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