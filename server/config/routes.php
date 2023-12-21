<?php
declare(strict_types=1);

use radio\net\app\action\podcast\GetAllPodcasts;
use radio\net\app\action\podcast\GetPodcastByDate;
use radio\net\app\action\podcast\GetPodcastByEmission;
use radio\net\app\action\podcast\GetPodcastByIdAction;
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
};