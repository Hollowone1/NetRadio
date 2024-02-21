<?php

use Psr\Container\ContainerInterface;
use radio\net\app\action\auth\RefreshAction;
use radio\net\app\action\auth\SigninAction;
use radio\net\app\action\auth\SignupAction;
use radio\net\app\action\auth\ValidateAction;
use radio\net\app\action\emission\GetEmissionById;
use radio\net\app\action\emission\GetEmissionsAction;
use radio\net\app\action\playlist\GetPlaylistByIdAction;
use radio\net\app\action\podcast\GetAllPodcasts;
use radio\net\app\action\podcast\GetPodcastByEmission;
use radio\net\app\action\podcast\GetPodcastByIdAction;
use radio\net\app\action\podcast\GetUSersByPodcast;
use radio\net\app\action\podcast\PostPodcast;
use radio\net\app\action\podcast\PutPodcast;
use radio\net\app\action\son\GetAllSons;
use radio\net\app\action\son\GetSonByIdAction;
use radio\net\app\action\son\GetSonsByPlaylistId;
use radio\net\app\action\user\GetUserAllInfo;
use radio\net\app\action\user\GetUserByMail;
use radio\net\app\action\user\PutUser;
use radio\net\domaine\service\playlist\PlaylistService;
use radio\net\domaine\service\son\SonService;

return array(
    //podcast
    GetPodcastByIdAction::class => function (ContainerInterface $container) {
        return new GetPodcastByIdAction($container->get('PodcastService'));
    },
    PostPodcast::class => function (ContainerInterface $container) {
        return new PostPodcast($container->get('PodcastService'));
    },
    PutPodcast::class => function (ContainerInterface $container) {
        return new PutPodcast($container->get('PodcastService'));
    },
    GetAllPodcasts::class => function (ContainerInterface $container) {
        return new GetAllPodcasts($container->get('PodcastService'));
    },
    GetPodcastByEmission::class => function (ContainerInterface $container) {
        return new GetPodcastByEmission($container->get('PodcastService'));
    },
    GetUSersByPodcast::class => function (ContainerInterface $container) {
        return new GetUSersByPodcast($container->get('PodcastService'));
    },

    //emission
    GetEmissionById::class => function (ContainerInterface $container) {
        return new GetEmissionById($container->get('EmissionService'));
    },
    GetEmissionsAction::class => function (ContainerInterface $container) {
        return new GetEmissionsAction($container->get('EmissionService'));
    },
    \radio\net\app\action\emission\GetCreneauByEmission::class => function (ContainerInterface $container) {
        return new \radio\net\app\action\emission\GetCreneauByEmission($container->get('EmissionService'));
    },

    //user
    GetUserAllInfo::class => function (ContainerInterface $container) {
        return new GetUserAllInfo($container->get('UserService'));
    },
    GetUserByMail::class => function (ContainerInterface $container) {
        return new GetUserByMail($container->get('UserService'));
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
    PutUser::class => function (ContainerInterface $container) {
        return new PutUser($container->get('UserService'));
    },

    //users
    SigninAction::class => function (ContainerInterface $container) {
        return new SigninAction($container->get('AuthService'));
    },

    SignupAction::class => function (ContainerInterface $container) {
        return new SignupAction($container->get('AuthService'));
    },

    ValidateAction::class => function (ContainerInterface $container) {
        return new ValidateAction($container->get('AuthService'));
    },

    RefreshAction::class => function (ContainerInterface $container) {
        return new RefreshAction($container->get('AuthService'));
    },
);
