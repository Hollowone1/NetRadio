<?php

use Psr\Container\ContainerInterface;
use radio\net\app\action\podcast\GetAllPodcasts;
use radio\net\app\action\podcast\GetPodcastByDate;
use radio\net\app\action\podcast\GetPodcastByEmission;
use radio\net\app\action\podcast\GetPodcastByIdAction;

return array(
    GetPodcastByIdAction::class => function (ContainerInterface $container) {
        return new GetPodcastByIdAction($container->get('PodcastService'));
    },
    GetPodcastByDate::class => function (ContainerInterface $container) {
        return new GetPodcastByDate($container->get('PodcastService'));
    },
    GetAllPodcasts::class => function (ContainerInterface $container) {
        return new GetAllPodcasts($container->get('PodcastService'));
    },
    GetPodcastByEmission::class => function (ContainerInterface $container) {
        return new GetPodcastByEmission($container->get('PodcastService'));
    },
    \radio\net\app\action\emission\GetEmissionById::class => function (ContainerInterface $container) {
        return new \radio\net\app\action\emission\GetEmissionById($container->get('EmissionService'));
    },
    \radio\net\app\action\emission\GetEmissionsAction::class => function (ContainerInterface $container) {
        return new \radio\net\app\action\emission\GetEmissionsAction($container->get('EmissionService'));
    },

    \radio\net\app\action\user\GetUserAllInfo::class => function (ContainerInterface $container) {
        return new \radio\net\app\action\user\GetUserAllInfo($container->get('UserService'));
    },
    \radio\net\app\action\user\GetUserByMail::class => function (ContainerInterface $container) {
        return new \radio\net\app\action\user\GetUserByMail($container->get('UserService'));
    }
);
