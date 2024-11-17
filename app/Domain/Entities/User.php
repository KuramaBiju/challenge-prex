<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserName;
use App\Domain\ValueObjects\UserPassword;

final class User
{
    private UserName $name;
    private UserEmail $email;
    private UserPassword $password;

    public function __construct(UserName $name, UserEmail $email, UserPassword $password) {

        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
    public static function create(array $data): self {
        return new self(
            new UserName($data['name']),
            new UserEmail($data['email']),
            new UserPassword($data['password'])
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name->value(),
            'email' => $this->email->value(),
            'password' => $this->password->getHashedPassword(),
        ];
    }
}
