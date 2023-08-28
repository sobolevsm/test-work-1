<?php

namespace App\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Infrastructure\Repository\ProductSqlRepository;

#[ORM\Entity(repositoryClass: ProductSqlRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $photoUrl = null;

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setPrice(?int $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setPhotoUrl(?string $photoUrl): void
    {
        $this->photoUrl = $photoUrl;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }
}
