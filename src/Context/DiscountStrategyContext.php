<?php

declare(strict_types=1);

namespace App\Context;

use App\Contract\DiscountStrategyContract;
use App\Model\Order;

class DiscountStrategyContext {
    private array $strategies = [];

    public function addStrategy(DiscountStrategyContract $strategy): void {
        $this->strategies[] = $strategy;
    }

    public function setDiscounts(Order $order): void {
        foreach ($this->strategies as $strategy) {
            $strategy->setDiscount($order);
        }
    }
}