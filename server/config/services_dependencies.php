<?php

use \Psr\Container\ContainerInterface;
use radio\net\app\service\podcast\PodcastService;

return [
    'GetPodcastByIdAction' => function (ContainerInterface $container) {
        return new PodcastService();
    }
];