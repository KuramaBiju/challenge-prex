<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class UserEmail {

    private $email;

    public function __construct(string $email) {
        $this->ensureEmailIsValid($email);
        $this->ensureEmailIsNotTooLong($email);
        $this->email = $email;
    }

    public function __toString() {
        return $this->email;
    }

    public function value(): string {
        return $this->email;
    }

    private function ensureEmailIsValid(string $email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format');
        }
    }


    private function ensureEmailIsNotTooLong(string $email) {
        if (strlen($email) > 100) {
            throw new InvalidArgumentException('Email is too long');
        }
    }
}
