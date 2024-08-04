<?php

declare(strict_types=1);

namespace App\Model;

final class Discount
{
    public float $amount;
    public string $reason;

    public function __construct(float $amount, string $reason)
    {
        $this->amount = round($amount, 2);
        $this->reason = $reason;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'reason' => $this->reason,
        ];
    }
}