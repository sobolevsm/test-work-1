<?php

namespace App\Infrastructure\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateProductRequest
{
    #[Assert\Type(type: 'string')]
    public $title;

    #[Assert\Type(type: 'int')]
    public $price;

    #[Assert\Type(type: 'string')]
    public $photo;

    #[Assert\Type(type: 'string')]
    public $description;
}
