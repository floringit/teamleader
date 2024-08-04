<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Transformer\OrderTransformer;
use Tests\BaseTestCase;

class OrderTransformerTest extends BaseTestCase
{
    protected OrderTransformer $orderTransformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderTransformer = new OrderTransformer($this->customerRepository, $this->productRepository);
    }

    public function testOrderTransformed()
    {
        $data = [
            'customer-id' => 2,
            'items' => [
                ['product-id' => 'A101', 'quantity' => 3, 'unit-price' => 9.75, 'total' => 29.25],
                ['product-id' => 'A102', 'quantity' => 1, 'unit-price' => 49.5, 'total' => 49.5],
                ['product-id' => 'B101', 'quantity' => 11, 'unit-price' => 4.99, 'total' => 54.89],
                ['product-id' => 'B102', 'quantity' => 7, 'unit-price' => 4.99, 'total' => 34.93]
            ]
        ];

        $order = $this->orderTransformer->transform($data);

        $this->assertObjectHasProperty('products', $order);
        $this->assertCount(4, $order->products);
        $this->assertIsObject($order->customer);
    }
}
