<?php
header("Access-Control-Allow-Origin: *");

use radio\net\domaine\middleware\Cors;
use radio\net\domaine\utils\Eloquent;
use Slim\Factory\AppFactory;

//ajout des dépendances
$settings = require_once __DIR__ . DIRECTORY_SEPARATOR . 'settings.php';
$dependancies = require_once __DIR__ . DIRECTORY_SEPARATOR . 'services_dependencies.php';
$actions = require_once __DIR__ . DIRECTORY_SEPARATOR . 'actions.php';

// ajoute les dépendances dans un container builder qui va lui les intégrer à l'app
$build = new \DI\ContainerBuilder();
$build->addDefinitions($settings);
$build->addDefinitions($dependancies);
$build->addDefinitions($actions);
$container = $build->build();

//creation de l'app à partir du container
$app = $container->get('app');

//cors
$app->add(new Cors());

//connexion à la base de données
$container->get('db');

//ajout des middlewares
$container->get('middlewares');

return $app;