<?php

namespace radio\net\domaine\service\playlist;

use radio\net\domaine\entities\Playlist;

class PlaylistService implements iPlaylistService
{

    public function getPlaylistById($id)
    {
        try {
            $playlist = Playlist::find($id);
            if ($playlist == null) {
                throw new PlaylistNotFoundException();
            }
            return $playlist;
        } catch (PlaylistNotFoundException $e) {
            throw $e;
        }
    }


    public function getAllPlaylists()
    {
        try {
            $playlist = Playlist::all();
            if ($playlist == null) {
                throw new PlaylistNotFoundException();
            }
            return $playlist;
        } catch (PlaylistNotFoundException $e) {
            throw $e;
        }
    }
}