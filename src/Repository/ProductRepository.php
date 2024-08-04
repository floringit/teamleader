<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Product;

final class ProductRepository extends BaseRepository
{
    protected $model = Product::class;
}