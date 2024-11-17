<?php

namespace Tests\Feature\unit;

use App\Application\UseCases\SaveGifUseCase;
use App\Domain\Entities\Gif;
use App\Domain\Repositories\GifWriteRepository;
use App\Domain\ValueObjects\GifAlias;
use App\Domain\ValueObjects\GifId;
use App\Domain\ValueObjects\UserId;
use Mockery;
use Tests\TestCase;

class SaveGifUseCaseTest extends TestCase
{
    protected $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var \Mockery\LegacyMockInterface&\Mockery\MockInterface|GifWriteRepository $repositoryMock */
        $this->repositoryMock = Mockery::mock(GifWriteRepository::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_saves_gif_with_valid_data(): void
    {
        $userId = 1;
        $gifId = "testId123";
        $alias = "Pepe Mujica";

        $this->repositoryMock->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function ($gif) use ($gifId, $userId, $alias) {
                $this->assertInstanceOf(Gif::class, $gif);
                $this->assertEquals($gifId, $gif->getId()->value());
                $this->assertEquals($userId, $gif->getUserId()->value());
                $this->assertEquals($alias, $gif->getAlias()->value());
                return true;
            }))
            ->andReturn(true);

        $useCase = new SaveGifUseCase($this->repositoryMock);
        $useCase->execute($userId, $gifId, $alias);

        $this->repositoryMock->shouldHaveReceived('save')->once();
    }


    public function test_saves_gif_with_invalid_data(): void
    {
        $userId = 1;
        $gifId = "";
        $alias = "";

        $this->expectException(\InvalidArgumentException::class);

        $useCase = new SaveGifUseCase($this->repositoryMock);
        $useCase->execute($userId, $gifId, $alias);

    }
}
