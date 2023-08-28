<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Entity\Product;
use App\Infrastructure\Entity\Product as ProductOrmEntity;

class ProductMapper
{
    public function toOrmEntity(Product $product): ProductOrmEntity
    {
        $productOrmEntity = new ProductOrmEntity();

        $productOrmEntity->setId($product->getId());
        $productOrmEntity->setTitle($product->getTitle());
        $productOrmEntity->setPrice($product->getPrice());
        $productOrmEntity->setDescription($product->getDescription());
        $productOrmEntity->setPhotoUrl($product->getPhoto());

        return $productOrmEntity;
    }

    public function toDomainEntity(ProductOrmEntity $productOrmEntity): Product
    {
        $product = new Product();

        $product->setId($productOrmEntity->getId());
        $product->setTitle($productOrmEntity->getTitle());
        $product->setPrice($productOrmEntity->getPrice());
        $product->setPhoto($productOrmEntity->getPhotoUrl());
        $product->setDescription($productOrmEntity->getDescription());

        return $product;
    }

    /**
     * @param ProductOrmEntity[] $productOrmEntities
     * @return Product[]
     */
    public function toDomainEntityArray(array $productOrmEntities): array
    {
        return array_map(
            fn(ProductOrmEntity $productOrmEntity) => $this->toDomainEntity($productOrmEntity),
            $productOrmEntities
        );
    }
}
