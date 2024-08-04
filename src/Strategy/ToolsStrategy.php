<?php

declare(strict_types=1);

namespace App\Strategy;

use App\Contract\DiscountStrategyContract;
use App\Model\Discount;
use App\Model\Order;

const TOOLS_MIN_QUANTITY = 2;
const TOOLS_DISCOUNT_PERCENTAGE = 0.2;
const TOOLS_CATEGORY = 1;
const TOOLS_DISCOUNT_CODE = 'TOOLS';

class ToolsStrategy implements DiscountStrategyContract {
    private array $filteredProducts = [];
    private float $cheapestPrice = 0;

    private function filterProducts(Order $order): void {
        $products = [];
        $index = 0;
        $cheapestPrice = 0;
        foreach ($order->products as $product) {
            if ($product['product']->get('category') === TOOLS_CATEGORY) {
                $products[] = $product;

                $productPrice = $product['product']->get('price');
                if ($cheapestPrice === 0 || $productPrice < $cheapestPrice) {
                    $cheapestPrice = $productPrice;
                }

                $index++;
            }
        }

        $this->cheapestPrice = $cheapestPrice;
        $this->filteredProducts = $products;
    }

    public function shouldApply(Order $order): bool {
        return $order->total && count($this->filteredProducts) >= TOOLS_MIN_QUANTITY;
    }

    public function setDiscount(Order $order): void {
        $this->filterProducts($order);
        if ($this->shouldApply($order)) {
            $amount = $this->cheapestPrice * TOOLS_DISCOUNT_PERCENTAGE;
            $order->addDiscount(new Discount($amount, TOOLS_DISCOUNT_CODE));
        }
    }
}