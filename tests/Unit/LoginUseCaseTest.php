<?php

namespace Tests\Feature;

use App\Application\UseCases\LoginUseCase;
use App\Domain\Repositories\UserRepository;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserPassword;
use Mockery;
use Tests\TestCase;

class LoginUseCaseTest extends TestCase
{
    protected $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var \Mockery\LegacyMockInterface&\Mockery\MockInterface|UserRepository $repositoryMock */
        $this->repositoryMock = Mockery::mock(UserRepository::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_returns_access_token_on_successful_login()
    {
        $email = new UserEmail('KlWZS@example.com');
        $password = new UserPassword('password');

        $expectedResult = [
            "access_token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
            "token_type" => "Bearer",
            "expires_in" => 1800
        ];

        $this->repositoryMock->shouldReceive('login')
            ->with(Mockery::type(UserEmail::class), Mockery::type(UserPassword::class))
            ->once()
            ->andReturn($expectedResult);

        $useCase = new LoginUseCase($this->repositoryMock);
        $result = $useCase->execute($email->value(), $password->getPlainPassword());

        $this->assertEquals($expectedResult, $result);
    }

    public function test_returns_error_on_failed_login()
    {
        $email = new UserEmail('test@example.com');
        $password = new UserPassword('asdasd12');

        $expectedResult = [
            "message" => "Invalid credentials"
        ];

        $this->repositoryMock->shouldReceive('login')
            ->with(Mockery::type(UserEmail::class), Mockery::type(UserPassword::class))
            ->once()
            ->andReturn($expectedResult);

        $useCase = new LoginUseCase($this->repositoryMock);
        $result = $useCase->execute($email->value(), $password->getPlainPassword());

        $this->assertEquals($expectedResult, $result);
    }
}
