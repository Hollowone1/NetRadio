<?php

use Psr\Container\ContainerInterface;
use radio\net\domaine\service\emission\EmissionService;
use radio\net\domaine\service\podcast\PodcastService;

return [
    'PodcastService' => function (ContainerInterface $container) {
        return new PodcastService();
    },
    'EmissionService' => function (ContainerInterface $container) {
        return new EmissionService();
    },
    'UserService' => function (ContainerInterface $container) {
        return new \radio\net\domaine\service\user\UserService();
    }
];