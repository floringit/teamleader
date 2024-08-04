<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/Env.php';
require_once __DIR__.'/../Http/Response/DiscountResponse.php';
require_once __DIR__.'/../Factory/ResponseFactory.php';
$app = require __DIR__ . '/Container.php';
(require __DIR__ . '/Middlewares.php')($app);
(require __DIR__ . '/Database.php');
(require __DIR__ . '/Routes.php');
(require __DIR__ . '/NotFound.php')($app);

return $app;