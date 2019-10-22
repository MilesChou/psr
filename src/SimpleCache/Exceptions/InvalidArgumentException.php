<?php

namespace MilesChou\PsrSupport\SimpleCache\Exceptions;

use InvalidArgumentException as BaseInvalidArgumentException;
use Psr\SimpleCache\InvalidArgumentException as ContractInvalidArgumentException;

class InvalidArgumentException extends BaseInvalidArgumentException implements ContractInvalidArgumentException
{
}
