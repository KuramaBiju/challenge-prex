<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\User as UserEntity;
use App\Domain\Repositories\UserRepository;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserPassword;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class UserRepositoryEloquent implements UserRepository{

    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function login(UserEmail $email, UserPassword $password){
        try {
            if(!Auth::attempt(['email' => $email, 'password' => $password->getPlainPassword()])){
                throw new \DomainException('Invalid credentials');
            }

            $user = Auth::user();

            $eloquenUser = $this->model->whereId($user->id)->firstOrFail();

            $eloquenUser->tokens()->delete();
            $token = $eloquenUser->createToken('auth_token')->accessToken;

            return [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 1800
            ];
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function save(UserEntity $user): void{
        try {
            $this->model->fill($user->toArray());
            $this->model->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

