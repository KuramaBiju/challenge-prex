<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

const MAX_ID = 2147483647;
const MIN_ID = 1;
final class UserId
{
    private $id;
    public function __construct(int $id)
    {
        $this->ensureIdIsValid($id);
        $this->ensureIdIsNotTooLong($id);
        $this->id = $id;
    }

    public function value(): int
    {
        return $this->id;
    }

    private function ensureIdIsValid(int $id) {
        if ($id < MIN_ID) {
            throw new InvalidArgumentException('Id must be greater than 0');
        }
    }

    private function ensureIdIsNotTooLong(int $id) {
        if ($id > MAX_ID) {
            throw new InvalidArgumentException('Id is too long');
        }
    }



}
