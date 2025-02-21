<?php

namespace App\Exceptions;

use Exception;

class LimiteDeProduccion extends Exception
{
    public function __construct($message = "El productor llego al limite anual", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
