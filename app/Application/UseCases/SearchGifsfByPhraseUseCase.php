<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\GifReadRepository;

final class SearchGifsfByPhraseUseCase {

    protected GifReadRepository $repository;

    public function __construct(GifReadRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(string $query, int $limit, int $offset) {
        return $this->repository->findByPhrase($query, $limit, $offset);
    }
}
