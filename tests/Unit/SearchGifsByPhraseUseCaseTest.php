<?php

namespace Tests\Feature\unit;

use App\Application\UseCases\SearchGifsfByPhraseUseCase;
use App\Domain\Repositories\GifReadRepository;
use Mockery;
use Tests\TestCase;

class SearchGifsByPhraseUseCaseTest extends TestCase
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

    public function test_returns_gifs_data_when_found(): void
    {
        $query = 'tummytox';
        $limit = 10;
        $offset = 0;

        $expectedGifData = [
            'data' => [
                'type' => 'gif',
                'id' => 'CZl4CUsSMt0jLiBkHz',
                'url' => "https://giphy.com/gifs/Sensilab-tummytox-logotummytox-tummytoxbabe-CZl4CUsSMt0jLiBkHz",
                'title' => 'Tt GIF by Sensilab',
                'images' => [
                    'original' => [
                        'url' => "https://media3.giphy.com/media/CZl4CUsSMt0jLiBkHz/giphy.gif",
                    ],
                ],
            ],
        ];

        $this->repositoryMock->shouldReceive('findByPhrase')
            ->once()
            ->with($query, $limit, $offset)
            ->andReturn($expectedGifData);

        $useCase = new SearchGifsfByPhraseUseCase($this->repositoryMock);
        $result = $useCase->execute($query, $limit, $offset);

        $this->assertEquals($expectedGifData, $result);
    }

    public function test_returns_empty_data_when_no_gifs_found(): void
    {
        $query = '';
        $limit = 10;
        $offset = 0;
        $notFoundGifData = [
            'message' => json_encode([
                'data' => [],
                'meta' => [
                    'status' => 404,
                    'msg' => 'Not Found',
                    'response_id' => 'shcc09vw3jokah8vnw66orir3vg42tejs5yjv981'
                ]
            ])
        ];

        $this->repositoryMock->shouldReceive('findByPhrase')
            ->once()
            ->with($query, $limit, $offset)
            ->andReturn($notFoundGifData);

        $useCase = new SearchGifsfByPhraseUseCase($this->repositoryMock);
        $result = $useCase->execute($query, $limit, $offset);
        $this->assertEquals($notFoundGifData, $result);
    }
}
