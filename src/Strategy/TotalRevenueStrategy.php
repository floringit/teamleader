<?php

declare(strict_types=1);

namespace App\Strategy;

use App\Contract\DiscountStrategyContract;
use App\Model\Discount;
use App\Model\Order;

const DISCOUNT_PERCENTAGE = 0.1;
const MIN_REVENUE_AMOUNT = 1000;
const DISCOUNT_CODE = 'TOTAL_REVENUE';

class TotalRevenueStrategy implements DiscountStrategyContract {
    public function shouldApply(Order $order): bool {
        return $order->total && $order->customer->get('revenue') > MIN_REVENUE_AMOUNT;
    }

    public function setDiscount(Order &$order): void {
        if ($this->shouldApply($order)) {
            $amount = $order->total * DISCOUNT_PERCENTAGE;
            $order->addDiscount(new Discount($amount, DISCOUNT_CODE));
        }
    }
}