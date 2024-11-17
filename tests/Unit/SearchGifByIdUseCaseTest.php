<?php

namespace Tests\Feature\unit;

use App\Application\UseCases\SearchGifByIdUseCase;
use App\Domain\Repositories\GifReadRepository;
use Mockery;
use Tests\TestCase;

class SearchGifByIdUseCaseTest extends TestCase
{
    protected $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var \Mockery\LegacyMockInterface&\Mockery\MockInterface|GifReadRepository $repositoryMock */
        $this->repositoryMock = Mockery::mock(GifReadRepository::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_returns_gif_data_when_found(): void
    {
        $gifId = 'CZl4CUsSMt0jLiBkHz';
        $expectedGifData = [
            'data' => [
                'type' => 'gif',
                'id' => $gifId,
                'url' => "https://giphy.com/gifs/Sensilab-tummytox-logotummytox-tummytoxbabe-{$gifId}",
                'title' => 'Tt GIF by Sensilab',
                'images' => [
                    'original' => [
                        'url' => "https://media3.giphy.com/media/{$gifId}/giphy.gif",
                    ],
                ],
            ],
        ];

        $this->repositoryMock->shouldReceive('findById')
            ->once()
            ->with($gifId)
            ->andReturn($expectedGifData);

        $useCase = new SearchGifByIdUseCase($this->repositoryMock);
        $result = $useCase->execute($gifId);

        $this->assertEquals($expectedGifData, $result);
    }

    public function test_returns_empty_data_when_gif_not_found(): void
    {
        $gifId = 'CZl4CUsSMt0jLiBkHzjf';
        $expectedNotFoundGifData = [
            'message' => json_encode([
                'data' => [],
                'meta' => [
                    'status' => 404,
                    'msg' => 'Not Found',
                    'response_id' => 'shcc09vw3jokah8vnw66orir3vg42tejs5yjv981'
                ]
            ])
        ];

        $this->repositoryMock->shouldReceive('findById')
            ->once()
            ->with($gifId)
            ->andReturn($expectedNotFoundGifData);

        $useCase = new SearchGifByIdUseCase($this->repositoryMock);
        $result = $useCase->execute($gifId);

        $this->assertEquals($expectedNotFoundGifData, $result);
    }
}
