<?php

declare(strict_types=1);

use App\Factory\ResponseFactory;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use Pimple\Container;
use Pimple\Psr11\Container as Psr11Container;
use Slim\Factory\AppFactory;
use App\Transformer\OrderTransformer;
use App\Context\DiscountStrategyContext;

$container = new Container();
$app = AppFactory::create(
    new ResponseFactory(),
    new Psr11Container($container)
);

$container['productRepository'] = static fn (
    Container $container
): ProductRepository => new ProductRepository($container['db']);

$container['customerRepository'] = static fn (
    Container $container
): CustomerRepository => new CustomerRepository($container['db']);

$container['orderTransformer'] = static fn (
    Container $container
): OrderTransformer => new OrderTransformer($container['customerRepository'], $container['productRepository']);

$container['discountContext'] = static function (): DiscountStrategyContext {
    $context = new DiscountStrategyContext();
    $context->addStrategy(new \App\Strategy\TotalRevenueStrategy());
    $context->addStrategy(new \App\Strategy\SwitchesStrategy());
    $context->addStrategy(new \App\Strategy\ToolsStrategy());

    return $context;
};

$container['notFoundHandler'] = static function () {
    return static function ($request, $response): void {
        throw new \App\Exception\RouteNotFound('Route Not Found.', 404);
    };
};

return $app;