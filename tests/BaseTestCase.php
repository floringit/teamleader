<?php

declare(strict_types=1);

namespace Tests;

use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    protected CustomerRepository $customerRepository;
    protected ProductRepository $productRepository;

    protected function setUp(): void
    {
        $db = $this->getDbConnection();
        $this->customerRepository = new CustomerRepository($db);
        $this->productRepository = new ProductRepository($db);
    }

    protected function getDbConnection(): \PDO
    {
        $pdo = new \PDO("sqlite::memory:");

        $sql = file_get_contents(__DIR__ . '/data.sql');
        $pdo->exec($sql);

        return $pdo;
    }
}
