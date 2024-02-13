<?php

use Psr\Container\ContainerInterface;
use radio\net\app\action\playlist\GetPlaylistByIdAction;
use radio\net\app\action\podcast\GetAllPodcasts;
use radio\net\app\action\podcast\GetPodcastByEmission;
use radio\net\app\action\podcast\GetPodcastByIdAction;
use radio\net\app\action\son\GetAllSons;
use radio\net\app\action\son\GetSonByIdAction;
use radio\net\app\action\son\GetSonsByPlaylistId;
use radio\net\domaine\service\playlist\PlaylistService;
use radio\net\domaine\service\son\SonService;

return array(
    GetPodcastByIdAction::class => function (ContainerInterface $container) {
        return new GetPodcastByIdAction($container->get('PodcastService'));
    },
    \radio\net\app\action\podcast\PostPodcast::class => function (ContainerInterface $container) {
        return new \radio\net\app\action\podcast\PostPodcast($container->get('PodcastService'));
    },
    \radio\net\app\action\podcast\PutPodcast::class => function (ContainerInterface $container) {
        return new \radio\net\app\action\podcast\PutPodcast($container->get('PodcastService'));
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
    \radio\net\app\action\emission\GetEmissionByTheme::class => function (ContainerInterface $container) {
        return new \radio\net\app\action\emission\GetEmissionByTheme($container->get('EmissionService'));
    },
    \radio\net\app\action\user\GetUserAllInfo::class => function (ContainerInterface $container) {
        return new \radio\net\app\action\user\GetUserAllInfo($container->get('UserService'));
    },
    \radio\net\app\action\user\GetUserByMail::class => function (ContainerInterface $container) {
        return new \radio\net\app\action\user\GetUserByMail($container->get('UserService'));
    },
    GetAllSons::class => function (ContainerInterface $container) {
        return new GetAllSons($container->get(SonService::class));
    },
    GetSonByIdAction::class => function (ContainerInterface $container) {
        return new GetSonByIdAction($container->get(SonService::class));
    },
    // ne marche pas
    GetSonsByPlaylistId::class => function (ContainerInterface $container) {
        return new GetSonsByPlaylistId($container->get(SonService::class));
    },
    GetPlaylistByIdAction::class => function (ContainerInterface $container) {
        return new GetPlaylistByIdAction($container->get(PlaylistService::class));
    },
);
