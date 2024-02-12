<?php
declare(strict_types=1);

use radio\net\app\action\podcast\GetAllPodcasts;
use radio\net\app\action\podcast\GetPodcastByDate;
use radio\net\app\action\podcast\GetPodcastByEmission;
use radio\net\app\action\podcast\GetPodcastByIdAction;
use radio\net\app\action\son\GetAllSons;
use Slim\App;

return function (App $app) {

    //podcast
    $app->get("/podcast/{id_podcast}[/]", GetPodcastByIdAction::class);
    $app->get("/podcasts[/]", GetAllPodcasts::class);
    $app->get("/podcasts/date", GetPodcastByDate::class);

    //emission
    $app->get("/emission/{id_emission}/podcasts", GetPodcastByEmission::class);
    $app->get("/emission/{id_emission}[/]", \radio\net\app\action\emission\GetEmissionById::class)->setName('/emission/{id_emission}[/]');
    $app->get("/emissions[/]", \radio\net\app\action\emission\GetEmissionsAction::class)->setName('/emissions');
    $app->get("/emissions/theme/{theme}", \radio\net\app\action\emission\GetEmissionByTheme::class)->setName('/emissions/theme');

    //users
    $app->get("/users", \radio\net\app\action\user\GetUserAllInfo::class);
    $app->get("/user/{id_user}[/]", \radio\net\app\action\user\GetUserByMail::class)->setName('/user/{id_user}[/]');

    //sons
    $app->get("/sons[/]", GetAllSons::class);
    $app->get("/son/{id_son}[/]", \radio\net\app\action\son\GetSonByIdAction::class)->setName('/son/{id_son}[/]');
    $app->get("/son/playlist/{id_playlist}[/]", \radio\net\app\action\son\GetSonsByPlaylistId::class)->setName('/son/playlist/{id_playlist}[/]');

    //playlist
    $app->get("/playlist/{id_playlist}[/]", \radio\net\app\action\playlist\GetPlaylistByIdAction::class)->setName('/playlist/{id_playlist}[/]');
    $app->get("/user/{email_user}/playlists", \radio\net\app\action\playlist\GetPlaylistByEmailUserAction::class)->setName('/user/{email_user}/playlist');
};


