<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Context\DiscountStrategyContext;
use App\Http\Response\DiscountResponse as Response;
use App\Transformer\OrderTransformer;
use Pimple\Psr11\Container;
use Psr\Http\Message\ServerRequestInterface as Request;

final class DiscountController
{
    private OrderTransformer $orderTransformer;
    private DiscountStrategyContext $discountStrategyContext;

    public function __construct(Container $container)
    {
        $this->orderTransformer = $container->get('orderTransformer');
        $this->discountStrategyContext = $container->get('discountContext');
    }

    public function index(Request $request, Response $response): Response
    {
        $body = [
            'customer-id' => 2,
            'items' => [
                ['product-id' => 'A101', 'quantity' => 3, 'unit-price' => 9.75, 'total' => 19.5],
                ['product-id' => 'A102', 'quantity' => 1, 'unit-price' => 49.5, 'total' => 49.5],
                ['product-id' => 'B101', 'quantity' => 11, 'unit-price' => 4.99, 'total' => 54.89],
                ['product-id' => 'B102', 'quantity' => 7, 'unit-price' => 4.99, 'total' => 34.93]
            ]
        ];

        $order = $this->orderTransformer->transform($body);
        $this->discountStrategyContext->setDiscounts($order);

        return $response->withJson($order->toArray());
    }
}