<?php
namespace App\Domain\Entities;

use App\Domain\ValueObjects\GifAlias;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\GifId;

final class Gif
{
    private GifId $gifId;
    private UserId $userId;
    private GifAlias $alias;

    public function __construct(GifId $gifId, UserId $userId, GifAlias $alias)
    {
        $this->gifId = $gifId;
        $this->userId = $userId;
        $this->alias = $alias;
    }

    public static function create(GifId $gifId, UserId $userId, GifAlias $alias): self {
        return new self(
            $gifId,
            $userId,
            $alias,
        );
    }


    public function toArray(): array
    {
        return [
            'user_id' => $this->userId->value(),
            'gif_id' => $this->gifId->value(),
            'alias' => $this->alias->value(),
        ];
    }
    public function getId(): GifId
    {
        return $this->gifId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getAlias(): GifAlias
    {
        return $this->alias;
    }
}
