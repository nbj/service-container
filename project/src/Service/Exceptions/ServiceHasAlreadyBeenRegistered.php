<?php

namespace Nbj\Service\Exceptions;

use Exception;
use Throwable;

class ServiceHasAlreadyBeenRegistered extends Exception
{
    /**
     * ServiceHasAlreadyBeenRegistered constructor.
     *
     * @param string $key
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($key, $code = 500, Throwable $previous = null)
    {
        $message = sprintf("A service with the key [%s] has already been registered", $key);

        parent::__construct($message, $code, $previous);
    }
}
