<?php

declare(strict_types=1);

namespace App\Model;

abstract class BaseModel
{
    public static string $table;

    public abstract function toArray(): array;

    public function get($name) {
        return $this->$name;
    }
}