<?php
declare(strict_types=1);

use Slim\App;

return function (App $app) {

    $app->get("/podcast/{id_podcast}[/]", \radio\net\app\action\GetPodcastByIdAction::class);
    $app->get("/podcasts", \radio\net\app\action\GetAllPodcasts::class);
    $app->get("/podcasts/date", \radio\net\app\action\GetPodcastByDate::class);
};