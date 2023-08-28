<?php

namespace App\Domain\Dto;

class UpdateProductDto
{
    private int $id;
    private ?string $title;
    private ?int $price;
    private ?string $photo;
    private ?string $description;

    public function __construct(int $id, ?string $title, ?int $price, ?string $photo, ?string $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->photo = $photo;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
