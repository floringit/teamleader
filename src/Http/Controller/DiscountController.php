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
        $order = $this->orderTransformer->transform($request->getParsedBody());
        $this->discountStrategyContext->setDiscounts($order);

        return $response->withJson($order->toArray());
    }
}