<?php

namespace App\Domain\Scenario;

use App\Domain\Entity\Product;
use App\Domain\Dto\CreateProductDto;
use App\Domain\Dto\UpdateProductDto;
use App\Domain\Exception\ProductNotFoundException;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\ExternalSource\ExternalProductSourceInterface;

class ProductScenario
{
    private ProductRepositoryInterface $productRepository;
    private ExternalProductSourceInterface $externalProductSource;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ExternalProductSourceInterface $externalProductSource
    ) {
        $this->productRepository = $productRepository;
        $this->externalProductSource = $externalProductSource;
    }

    public function createProduct(CreateProductDto $dto): void
    {
        $product = new Product();

        $externalProductDto = $this->externalProductSource->getProduct($dto->getUrl());

        $product->setTitle($externalProductDto->getTitle());
        $product->setPrice($externalProductDto->getPrice());
        $product->setPhoto($externalProductDto->getPhoto());
        $product->setDescription($dto->getDescription());

        $this->productRepository->save($product);
    }

    /**
     * @throws ProductNotFoundException
     */
    public function updateProduct(UpdateProductDto $dto): void
    {
        $productId = $dto->getId();

        $product = $this->productRepository->getProductById($productId);

        if (!$product) {
            throw new ProductNotFoundException($productId);
        }

        $product->setId($productId);
        $product->setTitle($dto->getTitle());
        $product->setPrice($dto->getPrice());
        $product->setPhoto($dto->getPhoto());
        $product->setDescription($dto->getDescription());

        $this->productRepository->update($product);
    }

    /**
     * @throws ProductNotFoundException
     */
    public function deleteProduct(int $id): void
    {
        $product = $this->productRepository->getProductById($id);

        if (!$product) {
            throw new ProductNotFoundException($id);
        }

        $this->productRepository->delete($product);
    }

    /**
     * @throws ProductNotFoundException
     */
    public function viewProduct(int $id): ?Product
    {
        $product = $this->productRepository->getProductById($id);

        if (!$product) {
            throw new ProductNotFoundException($id);
        }

        return $product;
    }
}
