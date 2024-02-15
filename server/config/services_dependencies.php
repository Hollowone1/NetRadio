<?php

use Psr\Container\ContainerInterface;
use radio\net\domaine\manager\JwtManager;
use radio\net\domaine\provider\AuthProvider;
use radio\net\domaine\service\auth\AuthService;
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
    },
    'JwtManager' => function(ContainerInterface $c) {
        $manager = new JwtManager($c->get('auth.token.secret'), $c->get('auth.token.expiration'));
        $manager->setIssuer($c->get('auth.token.issuer'));
        return $manager;
    },
    'AuthProvider' => function(ContainerInterface $c) {
        return new AuthProvider();
    },
    'AuthService' => function(ContainerInterface $c) {
        return new AuthService($c->get('JwtManager'), $c->get('AuthProvider'), $c->get('logger'));
    },
    'logger' => function(ContainerInterface $c) {
        $log = new \Monolog\Logger($c->get('auth.log.name'));
        $log->pushHandler(new \Monolog\Handler\StreamHandler($c->get('auth.log.file'), $c->get('auth.log.level')));
        return $log;
    },
];