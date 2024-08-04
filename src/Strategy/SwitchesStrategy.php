<?php

declare(strict_types=1);

namespace App\Strategy;

use App\Contract\DiscountStrategyContract;
use App\Model\Discount;
use App\Model\Order;

const MIN_QUANTITY = 6;
const SWITCHES_CATEGORY = 2;
const SWITCHES_DISCOUNT_CODE = 'SWITCHES';

class SwitchesStrategy implements DiscountStrategyContract {
    private array $filteredProducts = [];

    private function filterProducts(Order $order): void {
        $products = [];
        foreach ($order->products as $product) {
            if ($product['product']->get('category') === SWITCHES_CATEGORY && $product['quantity'] >= MIN_QUANTITY) {
                $products[] = $product;
            }
        }

        $this->filteredProducts = $products;
    }

    public function shouldApply(Order $order): bool {
        return $order->total && count($this->filteredProducts) > 0;
    }

    public function setDiscount(Order &$order): void {
        $this->filterProducts($order);
        if ($this->shouldApply($order)) {
            $amount = 0;
            foreach ($this->filteredProducts as $product) {
                $amount += $product['product']->get('price') * floor($product['quantity'] / MIN_QUANTITY);
            }

            $order->addDiscount(new Discount($amount, SWITCHES_DISCOUNT_CODE));
        }
    }
}