<?php

declare(strict_types=1);

namespace App\Contract;

interface TransformerContract {
    public function transform(array $data): array | object;
}