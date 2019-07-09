<?php

namespace Nbj\Service\Exceptions;

use Exception;
use Throwable;

class ServiceWasNotFound extends Exception
{
    /**
     * ServiceWasNotFound constructor.
     *
     * @param string $key
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($key, $code = 500, Throwable $previous = null)
    {
        $message = sprintf("No service was found with the key [%s]", $key);

        parent::__construct($message, $code, $previous);
    }
}
