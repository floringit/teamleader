<?php

declare(strict_types=1);

$app->get('/status', \App\Http\Controller\StatusController::class . ':index');
$app->get('/discount', \App\Http\Controller\DiscountController::class . ':index');