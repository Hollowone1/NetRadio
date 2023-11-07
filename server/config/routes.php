<?php
declare(strict_types=1);

use Slim\App;

return function (App $app) {
    $app->get("/", function () {
        echo "hello word";
    });
};