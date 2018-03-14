<?php
declare(strict_types=1);

namespace Genealogy\Exceptions;

use Exception;

/**
 * Class CannotCreateUser
 * @package Genealogy\Exceptions
 */
class CannotCreateUser extends Exception
{
    /**
     * @param string $username
     * @return CannotCreateUser
     */
    public static function duplicateUsername(string $username): self
    {
        return new static("The username [$username] already exists.");
    }
}
