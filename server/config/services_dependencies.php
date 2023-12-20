<?php

use Psr\Container\ContainerInterface;
use radio\net\domaine\service\podcast\PodcastService;

return [
    'PodcastService' => function (ContainerInterface $container) {
        return new PodcastService();
    }
];