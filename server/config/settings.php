<?php

use radio\net\domaine\utils\Eloquent;
use Slim\Factory\AppFactory;

return [
    'app' => function (\Psr\Container\ContainerInterface $container) {
        return AppFactory::createFromContainer($container);
    },
    'middlewares' => function (\Psr\Container\ContainerInterface $container) {
        //ajout des middleware
        $app = $container->get('app');
        $app->addBodyParsingMiddleware();
        $app->addRoutingMiddleware();
        $errorMiddleware = $app->addErrorMiddleware(true, false, false);
        $errorHandler = $errorMiddleware->getDefaultErrorHandler();
        $errorHandler->forceContentType('application/json');
    },
    'db' => function () {
        $eloquent = new Eloquent();
        $eloquent->init(__DIR__ . DIRECTORY_SEPARATOR . 'radio.db.ini', 'radio');
        return $eloquent;
    },
    'auth.token.secret' => 'CestMoiQuiALeSecret',
    'auth.token.expiration' => 3600,
    'auth.token.issuer' => $_SERVER['HTTP_HOST'],

    'auth.log.name' => 'auth',
    'auth.log.file' => __DIR__ . '/../logs/auth.log',
    'auth.log.level' => \Psr\Log\LogLevel::ALERT
];
