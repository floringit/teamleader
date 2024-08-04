<?php

declare(strict_types=1);

namespace App\Contract;

use App\Model\Order;

interface DiscountStrategyContract {
    public function setDiscount(Order $order): void;
    public function shouldApply(Order $order): bool;
}