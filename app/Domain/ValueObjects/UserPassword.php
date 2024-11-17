<?php

namespace App\Domain\ValueObjects;

use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

final class UserPassword
{
    private $password;
    private $hashedPassword;

    public function __construct(string $password, bool $isHashed = false)
    {
        $this->ensurePasswordIsValid($password);
        $this->ensurePasswordIsNotTooLong($password);

        if ($isHashed) {
            $this->hashedPassword = $password;
        } else {
            $this->password = $password;
            $this->hashedPassword = Hash::make($password);
        }
    }

    public function __toString(): string
    {
        return $this->hashedPassword;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function getPlainPassword(): string
    {
        return $this->password;
    }

    public function verify(string $password): bool
    {
        return Hash::check($password, $this->hashedPassword);
    }

    private function ensurePasswordIsValid(string $password) {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters long');
        }
    }

    private function ensurePasswordIsNotTooLong(string $password) {
        if (strlen($password) > 30) {
            throw new InvalidArgumentException('Password is too long');
        }
    }
}
