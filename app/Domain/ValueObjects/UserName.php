<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class UserName
{

    private $name;
    public function __construct(string $name)
    {
        $this->ensureNameIsValid($name);
        $this->ensureNameIsNotTooLong($name);
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function value(): string
    {
        return $this->name;
    }

    private function ensureNameIsValid(string $name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Name is required');
        }
    }

    private function ensureNameIsNotTooLong(string $name)
    {
        if (strlen($name) > 39) {
            throw new InvalidArgumentException('Name is too long');
        }
    }
}
