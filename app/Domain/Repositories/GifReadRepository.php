<?php

namespace App\Domain\Repositories;

use App\Domain\ValueObjects\GifId;

interface GifReadRepository {
    public function findById(GifId $id);
    public function findByPhrase(string $phrase, int $limit, int $offset);
}
