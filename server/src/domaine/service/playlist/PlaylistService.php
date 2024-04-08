<?php

namespace radio\net\domaine\service\playlist;

use radio\net\domaine\entities\Playlist;
use radio\net\domaine\entities\Son;

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

    public function getPlaylistsByEmailUser($emailUser) {
        try {
            $playlists = Playlist::where('emailUser', $emailUser)->get();
            if ($playlists == null) {
                throw new PlaylistNotFoundException();
            }
            return $playlists;
        } catch (PlaylistNotFoundException $e) {
            throw $e;
        }
    }

    public function createPlaylist($name, $description, $emailUser) {
        $playlist = new Playlist();
        $playlist->name = $name;
        $playlist->description = $description;
        $playlist->emailUser = $emailUser;
        $playlist->save();
        return $playlist;
    }

    // insert into playlistSon($idPlaylist, $idSon);

    public function postSonByPlaylist ($idPlaylist, $sonDTO) {
        $son = $this->createSon($sonDTO);

        $playlist = Playlist::findOrFail($idPlaylist);

        if ($playlist) {
            $playlist->sons()->attach($son->id);
        }
        return $playlist;
    }

    public function createSon($sonData)
    {
        $son = new Son();
        $son->titre = $sonData->titre;
        $son->nomArtiste = $sonData->nomArtiste;
        $son->audio = $sonData->audio;
        $son->save();

        return $son; // Retourne le son créé
    }

}