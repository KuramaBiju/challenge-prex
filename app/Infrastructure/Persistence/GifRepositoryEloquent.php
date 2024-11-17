<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Repositories\GifWriteRepository;
use App\Domain\Entities\Gif as GifEntity;
use App\Models\Gif;


final class GifRepositoryEloquent implements GifWriteRepository
{

    private $model;

    public function __construct()
    {
        $this->model = new Gif();
    }

    public function save(GifEntity $gif) : void
    {
        $this->model->fill($gif->toArray());
        $this->model->save();
    }
}
