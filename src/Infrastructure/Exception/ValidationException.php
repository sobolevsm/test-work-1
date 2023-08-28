<?php

namespace App\Infrastructure\Exception;

use Exception;
use Throwable;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends Exception
{
    private ConstraintViolationListInterface $violations;

    public function __construct(
        ConstraintViolationListInterface $violations,
        $message = '',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->violations = $violations;
    }

    public function __toString(): string
    {
        $currentViolations = $this->violations->get(0);
        return "{$currentViolations->getPropertyPath()}: {$currentViolations->getMessage()}";
    }
}
