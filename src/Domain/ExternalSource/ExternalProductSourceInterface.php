<?php

namespace App\Domain\ExternalSource;

interface ExternalProductSourceInterface
{
    public function getProduct(string $url): ExternalSourceProductDto;
}
