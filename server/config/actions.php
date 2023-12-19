<?php

use radio\net\app\action\GetPodcastByIdAction;
use \Psr\Container\ContainerInterface;

return [
    GetPodcastByIdAction::class => function (ContainerInterface $container) {
        return new GetPodcastByIdAction($container->get('GetPodcastByIdAction'));
    }
];
