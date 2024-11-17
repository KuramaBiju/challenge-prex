<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\GifReadRepository;
use App\Domain\ValueObjects\GifId;

final class SearchGifByIdUseCase {

    protected GifReadRepository $repository;

    public function __construct(GifReadRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(string $id){
        return $this->repository->findById(new GifId($id));
    }
}
