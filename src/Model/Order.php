<?php

declare(strict_types=1);

namespace App\Model;

use App\Contract\ModelContract;

final class Order
{
    public array $products;
    public array $discounts = [];
    public float $total = 0;

    public ModelContract $customer;

    public function __construct(array $products, ModelContract $customer)
    {
        $this->products = $products;
        $this->customer = $customer;
        $this->setTotal();
    }

    private function setTotal(): void
    {
        foreach ($this->products as $product) {
            $this->total += $product['product']->get('price') * $product['quantity'];
        }
    }

    public function addDiscount(Discount $discount): void
    {
        $this->discounts[] = $discount;
    }

    public function toArray(): array
    {
        return array_map(fn ($d) => $d->toArray(), $this->discounts);
    }
}