<?php
declare(strict_types=1);

use radio\net\app\action\podcast\GetAllPodcasts;
use radio\net\app\action\podcast\GetPodcastByEmission;
use radio\net\app\action\podcast\GetPodcastByIdAction;
use radio\net\app\action\son\GetAllSons;
use Slim\App;

return function (App $app) {

    //podcast
    $app->group('/podcasts', function ($app) {
        $app->get("/{id_podcast}[/]", GetPodcastByIdAction::class)->setName('podcast.show');
        $app->get("[/]", GetAllPodcasts::class)->setName('podcast.index');
        $app->post("[/]", \radio\net\app\action\podcast\PostPodcast::class)->setName('');
    });

    //emission
    $app->group('/emissions', function ($app) {
        $app->get("/{id_emission}/podcasts", GetPodcastByEmission::class)->setName('');
        $app->get("/{id_emission}[/]", \radio\net\app\action\emission\GetEmissionById::class)->setName('emission.show');
        $app->get("[/]", \radio\net\app\action\emission\GetEmissionsAction::class)->setName('/emissions')->setName('emission.index');
        $app->get("/theme/{theme}", \radio\net\app\action\emission\GetEmissionByTheme::class)->setName('/emissions/theme');
    });

    //users
    $app->group('/users', function ($app) {
        $app->get("[/]", \radio\net\app\action\user\GetUserAllInfo::class);
        $app->get("/{id_user}[/]", \radio\net\app\action\user\GetUserByMail::class)->setName('/user/{id_user}[/]');
    });

    //sons
    $app->group('/sons', function ($app) {
        $app->get("[/]", GetAllSons::class);
        $app->get("/{id_son}[/]", \radio\net\app\action\son\GetSonByIdAction::class)->setName('/son/{id_son}[/]');
        $app->get("/playlist/{id_playlist}[/]", \radio\net\app\action\son\GetSonsByPlaylistId::class)->setName('/son/playlist/{id_playlist}[/]');
    });

    //playlist
    $app->group('/playlists', function ($app) {
        $app->get("/{id_playlist}[/]", \radio\net\app\action\playlist\GetPlaylistByIdAction::class)->setName('/playlist/{id_playlist}[/]');
    });
};
