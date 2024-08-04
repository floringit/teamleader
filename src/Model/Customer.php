<?php

declare(strict_types=1);

namespace App\Model;

use App\Contract\ModelContract;

final class Customer extends BaseModel implements ModelContract
{
    public static string $table = 'customers';

    protected int $id;

    protected string $name;

    protected int $since;

    protected float $revenue;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'since' => $this->since,
            'revenue' => $this->revenue
        ];
    }
}