<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Contract\TransformerContract;
use App\Model\Order;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;

class OrderTransformer implements TransformerContract {
    private CustomerRepository $customerRepository;
    private ProductRepository $productRepository;

    public function __construct(CustomerRepository $customerRepository, ProductRepository $productRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
    }

    public function transform(array $data): Order {
        try {
            $customer = $this->customerRepository->getById($data['customer-id']);
        } catch (\Exception $e) {
            $customer = null;
        }

        if (!$customer) {
            throw new \Exception('Customer not found.', 404);
        }

        try {
            $productIds = array_map(fn ($p) => $p['product-id'], $data['items']);
            $products = $this->productRepository->getByIds($productIds);
        } catch (\Exception $e) {
            $products = [];
        }

        foreach ($products as $index => $product) {
            $products[$index] = ['product' => $product, 'quantity' => $data['items'][$index]['quantity']];
        }

        return new Order($products, $customer);
    }
}