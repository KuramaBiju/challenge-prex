<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Gif as GifEntity;
use App\Domain\Repositories\GifWriteRepository;
use App\Domain\ValueObjects\GifAlias;
use App\Domain\ValueObjects\GifId;
use App\Domain\ValueObjects\UserId;

final class SaveGifUseCase {

    protected GifWriteRepository $repository;

    public function __construct(GifWriteRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(int $user_id, string $gif_id, string $alias){
        $gif = GifEntity::create(
            new GifId($gif_id),
            new UserId($user_id),
            new GifAlias($alias)
        );
        $this->repository->save($gif);
    }
}
