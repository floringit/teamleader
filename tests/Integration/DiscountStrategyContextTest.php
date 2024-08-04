<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Context\DiscountStrategyContext;
use App\Strategy\SwitchesStrategy;
use App\Strategy\ToolsStrategy;
use App\Strategy\TotalRevenueStrategy;
use App\Transformer\OrderTransformer;
use Tests\BaseTestCase;

class DiscountStrategyContextTest extends BaseTestCase
{
    protected DiscountStrategyContext $discountContext;
    protected OrderTransformer $orderTransformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderTransformer = new OrderTransformer($this->customerRepository, $this->productRepository);
        $this->discountContext = new DiscountStrategyContext();
        $this->discountContext->addStrategy(new TotalRevenueStrategy());
        $this->discountContext->addStrategy(new SwitchesStrategy());
        $this->discountContext->addStrategy(new ToolsStrategy());
    }

    public function testTotalRevenueDiscountApplies()
    {
        $data = [
            'customer-id' => 2,
            'items' => [
                ['product-id' => 'A101', 'quantity' => 3, 'unit-price' => 9.75, 'total' => 29.25]
            ]
        ];

        $order = $this->orderTransformer->transform($data);
        $this->discountContext->setDiscounts($order);
        $discounts = $order->toArray();

        $this->assertCount(1, $discounts);
        $this->assertEquals('TOTAL_REVENUE', $discounts[0]['reason']);
        $this->assertEquals(2.93, $discounts[0]['amount']);
    }

    public function testTotalRevenueDiscountDoesNotApply()
    {
        $data = [
            'customer-id' => 1,
            'items' => [
                ['product-id' => 'A101', 'quantity' => 3, 'unit-price' => 9.75, 'total' => 29.25]
            ]
        ];

        $order = $this->orderTransformer->transform($data);
        $this->discountContext->setDiscounts($order);
        $discounts = $order->toArray();

        $this->assertCount(0, $discounts);
    }

    public function testSwitchesDiscountApplies()
    {
        $data = [
            'customer-id' => 1,
            'items' => [
                ['product-id' => 'B101', 'quantity' => 11, 'unit-price' => 4.99, 'total' => 54.89],
                ['product-id' => 'B102', 'quantity' => 7, 'unit-price' => 4.99, 'total' => 34.93]
            ]
        ];

        $order = $this->orderTransformer->transform($data);
        $this->discountContext->setDiscounts($order);
        $discounts = $order->toArray();

        $this->assertCount(1, $discounts);
        $this->assertEquals('SWITCHES', $discounts[0]['reason']);
        $this->assertEquals(9.98, $discounts[0]['amount']);
    }

    public function testSwitchesDiscountDoesNotApply()
    {
        $data = [
            'customer-id' => 1,
            'items' => [
                ['product-id' => 'B101', 'quantity' => 3, 'unit-price' => 4.99, 'total' => 54.89],
                ['product-id' => 'B102', 'quantity' => 4, 'unit-price' => 4.99, 'total' => 34.93]
            ]
        ];

        $order = $this->orderTransformer->transform($data);
        $this->discountContext->setDiscounts($order);
        $discounts = $order->toArray();

        $this->assertCount(0, $discounts);
    }

    public function testToolsDiscountApplies()
    {
        $data = [
            'customer-id' => 3,
            'items' => [
                ['product-id' => 'A101', 'quantity' => 3, 'unit-price' => 9.75, 'total' => 29.25],
                ['product-id' => 'A102', 'quantity' => 1, 'unit-price' => 49.5, 'total' => 49.5]
            ]
        ];

        $order = $this->orderTransformer->transform($data);
        $this->discountContext->setDiscounts($order);
        $discounts = $order->toArray();

        $this->assertCount(1, $discounts);
        $this->assertEquals('TOOLS', $discounts[0]['reason']);
        $this->assertEquals(1.95, $discounts[0]['amount']);
    }

    public function testToolsDiscountDoesNotApply()
    {
        $data = [
            'customer-id' => 3,
            'items' => [
                ['product-id' => 'A101', 'quantity' => 3, 'unit-price' => 9.75, 'total' => 29.25],
                ['product-id' => 'A102', 'quantity' => 1, 'unit-price' => 49.5, 'total' => 49.5]
            ]
        ];

        $order = $this->orderTransformer->transform($data);
        $this->discountContext->setDiscounts($order);
        $discounts = $order->toArray();

        $this->assertCount(1, $discounts);
        $this->assertEquals('TOOLS', $discounts[0]['reason']);
        $this->assertEquals(1.95, $discounts[0]['amount']);
    }

    public function testMultipleDiscountsApplies()
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
        $this->discountContext->setDiscounts($order);
        $discounts = $order->toArray();

        $this->assertCount(3, $discounts);
        $this->assertEquals('TOTAL_REVENUE', $discounts[0]['reason']);
        $this->assertEquals(16.86, $discounts[0]['amount']);
        $this->assertEquals('SWITCHES', $discounts[1]['reason']);
        $this->assertEquals(9.98, $discounts[1]['amount']);
        $this->assertEquals('TOOLS', $discounts[2]['reason']);
        $this->assertEquals(1.95, $discounts[2]['amount']);
    }
}
