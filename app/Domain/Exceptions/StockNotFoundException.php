<?php

namespace App\Domain\Exceptions;

use Exception;

class StockNotFoundException extends Exception
{
    public function __construct(string $message = "Produto não encontrado no estoque", int $code = 404)
    {
        parent::__construct($message, $code);
    }
} 