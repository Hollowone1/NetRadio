<?php
declare(strict_types=1);

use Slim\App;

return function (App $app) {
    $app->get("/", function ($req, $res, $args) {
        $res->getBody()->write("hello word !");
        return $res;
    });
};