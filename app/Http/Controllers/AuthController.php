<?php

namespace App\Http\Controllers;

use App\Application\UseCases\LoginUseCase;
use App\Application\UseCases\SaveUserUseCase;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Infrastructure\Persistence\UserRepositoryEloquent;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        try {
            $loginUseCase = new LoginUseCase(new UserRepositoryEloquent());
            $userAuthenticated = $loginUseCase->execute($request->email, $request->password);
            return response()->json($userAuthenticated, 200);
        }
        catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function save(RegisterUserRequest $request)
    {
        try {
            $registerUseCase = new SaveUserUseCase(new UserRepositoryEloquent());
            $registerUseCase->execute($request->name, $request->email, $request->password);
            return response()->json(['message' => 'User created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
