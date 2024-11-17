<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Gif as GifEntity;

interface GifWriteRepository{
    public function save(GifEntity $gif): void;
}
