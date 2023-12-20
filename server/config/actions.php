<?php

use Psr\Container\ContainerInterface;
use radio\net\app\action\GetAllPodcasts;
use radio\net\app\action\GetPodcastByDate;
use radio\net\app\action\GetPodcastByIdAction;

return array(
    GetPodcastByIdAction::class => function (ContainerInterface $container) {
        return new GetPodcastByIdAction($container->get('PodcastService'));
    },
    GetPodcastByDate::class => function (ContainerInterface $container) {
        return new GetPodcastByDate($container->get('PodcastService'));
    },
    GetAllPodcasts::class => function (ContainerInterface $container) {
        return new GetPodcastByDate($container->get('PodcastService'));
    }
);
