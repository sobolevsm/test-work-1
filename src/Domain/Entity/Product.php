<?php

namespace App\Domain\Entity;

class Product
{
    private ?int $id = null;
    private ?string $title = null;
    private ?int $price = null;
    private ?string $photo = null;
    private ?string $description = null;

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
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
}
