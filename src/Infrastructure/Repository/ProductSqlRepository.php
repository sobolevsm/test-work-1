<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Infrastructure\Mapper\ProductMapper;
use App\Infrastructure\Entity\Product as ProductEntity;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ProductSqlRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    private ProductMapper $mapper;

    public function __construct(ManagerRegistry $registry, ProductMapper $mapper)
    {
        parent::__construct($registry, ProductEntity::class);
        $this->mapper = $mapper;
    }

    public function getProductById(int $id): ?Product
    {
        $product = $this->find($id);

        return $product ? $this->mapper->toDomainEntity($product) : null;
    }

    public function getAllProducts(): array
    {
        return $this->mapper->toDomainEntityArray($this->findAll());
    }

    public function save(Product $product): void
    {
        $productOrmEntity = $this->mapper->toOrmEntity($product);

        $this->_em->persist($productOrmEntity);
        $this->_em->flush();
    }

    public function update(Product $product): void
    {
        $productOrmEntity = $this->_em->getReference(ProductEntity::class, $product->getId());

        $productOrmEntity->setTitle($product->getTitle());
        $productOrmEntity->setPrice($product->getPrice());
        $productOrmEntity->setPhotoUrl($product->getPhoto());
        $productOrmEntity->setDescription($product->getDescription());

        $this->_em->persist($productOrmEntity);
        $this->_em->flush();
    }

    public function delete(Product $product): void
    {
        $productOrmEntity = $this->_em->getReference(ProductEntity::class, $product->getId());

        $this->_em->remove($productOrmEntity);
        $this->_em->flush();
    }
}
