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
        $body = $request->getParsedBody();
        if (!$body) {
            return $response->withJson([]);
        }

        try {
            $order = $this->orderTransformer->transform($body);
            $this->discountStrategyContext->setDiscounts($order);
        } catch (\Exception $e) {
            return $response->withJson([]);
        }

        return $response->withJson($order->toArray());
    }
}