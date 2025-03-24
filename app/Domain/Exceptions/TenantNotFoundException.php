<?php

namespace App\Domain\Exceptions;

use Exception;

class TenantNotFoundException extends Exception
{
    public function __construct(string $message = "Tenant não encontrado", int $code = 404)
    {
        parent::__construct($message, $code);
    }
} 