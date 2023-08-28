<?php

namespace App\Domain\ExternalSource;

class ExternalSourceProductDto
{
    private ?string $title;
    private ?int $price;
    private ?string $photo;

    public function __construct(?string $title, ?int $price, ?string $photo)
    {
        $this->title = $title;
        $this->price = $price;
        $this->photo = $photo;
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
}
