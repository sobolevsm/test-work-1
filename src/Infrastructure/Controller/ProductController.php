<?php

namespace App\Infrastructure\Controller;

use App\Domain\Dto\CreateProductDto;
use App\Domain\Dto\UpdateProductDto;
use App\Domain\Scenario\ProductScenario;
use App\Domain\Exception\ProductNotFoundException;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Infrastructure\Request\UpdateProductRequest;
use App\Infrastructure\Request\CreateProductRequest;
use App\Infrastructure\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Exception;

class ProductController extends AbstractController
{
    private ProductRepositoryInterface $repository;
    private ProductScenario $scenario;

    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(
        ProductScenario $scenario,
        ProductRepositoryInterface $repository,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->scenario = $scenario;
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    #[Route('/api/products', name: 'product_new', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $rawRequest = $request->getContent();

        $createProductRequest = $this->serializer->deserialize($rawRequest, CreateProductRequest::class, 'json');

        $violations = $this->validator->validate($createProductRequest);

        if (count($violations) > 0) {
            return $this->json((string) new ValidationException($violations), Response::HTTP_BAD_REQUEST);
        }

        $createProductDto = new CreateProductDto($createProductRequest->url, $createProductRequest->description);

        try {
            $this->scenario->createProduct($createProductDto);
            return $this->json('', Response::HTTP_CREATED);
        } catch (Exception) {
            return $this->json('Ошибка при создании продукта', Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/api/products', name: 'product_list', methods: ['GET'])]
    public function list(): Response
    {
        return $this->json($this->repository->getAllProducts());
    }

    #[Route('/api/products/{id}', name: 'product_view', methods: ['GET'])]
    public function view(int $id): Response
    {
        try {
            $product = $this->scenario->viewProduct($id);
            return $this->json($product);
        } catch (ProductNotFoundException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/api/products/{id}', name: 'product_update', methods: ['PUT'])]
    public function update(Request $request, int $id): Response
    {
        $updateProductRequest = $this->serializer->deserialize(
            $request->getContent(),
            UpdateProductRequest::class,
            'json'
        );

        $violations = $this->validator->validate($updateProductRequest);

        if (count($violations) > 0) {
            return $this->json((string) new ValidationException($violations), Response::HTTP_BAD_REQUEST);
        }

        $updateProductDto = new UpdateProductDto(
            $id,
            $updateProductRequest->title,
            $updateProductRequest->price,
            $updateProductRequest->photo,
            $updateProductRequest->description
        );

        try {
            $this->scenario->updateProduct($updateProductDto);
            return $this->json('', Response::HTTP_OK);
        } catch (ProductNotFoundException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception) {
            return $this->json('Ошибка при обновлении продукта', Response::HTTP_BAD_REQUEST);
        }
    }


    #[Route('/api/products/{id}', name: 'product_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        try {
            $this->scenario->deleteProduct($id);
            return new Response(null, Response::HTTP_NO_CONTENT);
        } catch (ProductNotFoundException $exception) {
            return new Response($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception) {
            return $this->json('Ошибка при удалении продукта', Response::HTTP_BAD_REQUEST);
        }
    }
}
