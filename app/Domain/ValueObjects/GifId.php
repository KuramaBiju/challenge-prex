<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;


final class GifId
{
    private $id;
    public function __construct(string $id)
    {
        $this->ensureIdIsValid($id);
        $this->ensureIdIsNotTooLong($id);
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
    public function value(): string
    {
        return $this->id;
    }

    private function ensureIdIsValid(string $id) {
        if (empty($id)) {
            throw new InvalidArgumentException('Id is required');
        }
    }

    private function ensureIdIsNotTooLong(string $id) {
        if (strlen($id) > 50) {
            throw new InvalidArgumentException('Id is too long');
        }
    }
}
