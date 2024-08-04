<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Customer;

final class CustomerRepository extends BaseRepository
{
    protected $model = Customer::class;
}