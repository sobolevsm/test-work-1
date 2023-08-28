<?php

namespace App\Domain\Exception;

use Exception;

class ProductNotFoundException extends Exception
{
    public function __construct(int $productId)
    {
        parent::__construct("Product with Id = $productId not found!");
    }
}
