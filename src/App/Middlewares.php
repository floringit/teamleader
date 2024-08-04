<?php

declare(strict_types=1);

use Slim\App;

return static function (App $app): void {
    $path = $_SERVER['SLIM_BASE_PATH'] ?? '';
    $app->setBasePath($path);
    $app->addRoutingMiddleware();
    $app->addBodyParsingMiddleware();
};