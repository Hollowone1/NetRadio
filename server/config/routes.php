<?php
declare(strict_types=1);

use radio\net\app\action\creneau\GetAllCreneaux;
use radio\net\app\action\creneau\GetCreneauById;
use radio\net\app\action\emission\GetEmissionById;
use radio\net\app\action\emission\GetEmissionByTheme;
use radio\net\app\action\emission\GetEmissionsAction;
use radio\net\app\action\playlist\GetPlaylistByEmailUserAction;
use radio\net\app\action\playlist\GetPlaylistByIdAction;
use radio\net\app\action\playlist\PostPlaylist;
use radio\net\app\action\podcast\GetAllPodcasts;
use radio\net\app\action\podcast\GetPodcastByEmission;
use radio\net\app\action\podcast\GetPodcastByIdAction;
use radio\net\app\action\podcast\PostPodcast;
use radio\net\app\action\son\GetAllSons;
use radio\net\app\action\son\GetSonByIdAction;
use radio\net\app\action\son\GetSonsByPlaylistId;
use radio\net\app\action\user\GetUserAllInfo;
use radio\net\app\action\user\GetUserByMail;
use Slim\App;

return function (App $app) {

    //podcast
    $app->group('/podcasts', function ($app) {
        $app->get("/{id_podcast}[/]", GetPodcastByIdAction::class)->setName('podcast.show');
        $app->get("[/]", GetAllPodcasts::class)->setName('podcast.index');
        $app->post("[/]", PostPodcast::class)->setName('');
    });

    //emission
    $app->group('/emissions', function ($app) {
        $app->get("/{id_emission}/podcasts", GetPodcastByEmission::class)->setName('');
        $app->get("/{id_emission}[/]", GetEmissionById::class)->setName('emission.show');
        $app->get("[/]", GetEmissionsAction::class)->setName('/emissions')->setName('emission.index');
        $app->get("/theme/{theme}", GetEmissionByTheme::class)->setName('/emissions/theme');
    });

    //users
    $app->group('/users', function ($app) {
        $app->get("[/]", GetUserAllInfo::class);
        $app->get("/{id_user}[/]", GetUserByMail::class)->setName('/user/{id_user}[/]');
        $app->get("/{email_user}/playlists", GetPlaylistByEmailUserAction::class)->setName('/user/{email_user}/playlist');

    });

    //sons
    $app->group('/sons', function ($app) {
        $app->get("[/]", GetAllSons::class);
        $app->get("/{id_son}[/]", GetSonByIdAction::class)->setName('/son/{id_son}[/]');
        $app->get("/playlist/{id_playlist}[/]", GetSonsByPlaylistId::class)->setName('/son/playlist/{id_playlist}[/]');
    });

    //playlist
    $app->group('/playlists', function ($app) {
        $app->get("/{id_playlist}[/]", GetPlaylistByIdAction::class)->setName('/playlist/{id_playlist}[/]');
        $app->post("[/]", PostPlaylist::class)->setName("/playlist");
    });

    // creneau
    $app->group('/creneaux', function ($app) {
        $app->get("[/]", GetAllCreneaux::class);
        $app->get("/{id}[/]", GetCreneauById::class);
    });
};
