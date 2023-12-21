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
    $app->get("/emission/{id_emission}[/]", \radio\net\app\action\emission\GetEmissionById::class);

    //users
    $app->get("/users", \radio\net\app\action\user\GetUserAllInfo::class);
};