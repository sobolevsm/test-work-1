<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function getProductById(int $id): ?Product;

    /**
     * @return Product[]
     */
    public function getAllProducts(): array;

    public function save(Product $product): void;
    public function update(Product $product): void;
    public function delete(Product $product): void;
}
