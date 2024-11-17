<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\User as UserEntity;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserPassword;

interface UserRepository{
    public function login(UserEmail $emai, UserPassword $password);
    public function save(UserEntity $user): void;

}
