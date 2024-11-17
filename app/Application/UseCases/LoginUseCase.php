<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\UserRepository;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserPassword;

final class LoginUseCase {

    protected UserRepository $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(string $email, string $password){

        return $this->repository->login(new UserEmail($email), new UserPassword($password, false));
    }
}
