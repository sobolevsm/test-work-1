<?php

namespace App\Domain\Dto;

class CreateProductDto
{
    private string $url;
    private ?string $description;

    public function __construct(string $url, ?string $description)
    {
        $this->url = $url;
        $this->description = $description;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
