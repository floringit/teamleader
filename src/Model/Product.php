<?php

declare(strict_types=1);

namespace App\Model;

use App\Contract\ModelContract;

final class Product extends BaseModel implements ModelContract
{
    public static string $table = 'products';

    protected string $id;

    protected string $description;

    protected int $category;

    protected float $price;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'category' => $this->category,
            'price' => $this->price
        ];
    }
}