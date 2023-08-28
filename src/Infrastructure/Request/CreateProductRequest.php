<?php

namespace App\Infrastructure\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CreateProductRequest
{
    #[Assert\NotBlank]
    #[Assert\Url]
    public $url;

    #[Assert\Type(type: 'string')]
    public $description;
}
