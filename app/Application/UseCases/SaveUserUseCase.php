<?php

namespace App\Application\UseCases;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserName;
use App\Domain\ValueObjects\UserPassword;

final class SaveUserUseCase {

    protected UserRepository $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(string $name, string $email, string $password) {
        $user = new User(
            new UserName($name),
            new UserEmail($email),
            new UserPassword($password)
        );
        $this->repository->save($user);
    }
}
