<?php
declare(strict_types=1);

use Slim\App;

return function (App $app) {
    $app->get("/podcast/{id_podcast}[/]", \radio\net\app\action\GetPodcastByIdAction::class);
};