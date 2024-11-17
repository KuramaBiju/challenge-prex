<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class GifAlias {

    private $alias;

    public function __construct(string $alias)
    {
        $this->ensureAliasIsValid($alias);
        $this->ensureAliasIsNotTooLong($alias);
        $this->alias = $alias;
    }

    public function __toString() {
        return $this->alias;
    }

    public function value(): string {
        return $this->alias;
    }

    private function ensureAliasIsNotTooLong(string $alias) {
        if (strlen($alias) > 50) {
            throw new InvalidArgumentException('Alias is too long');
        }
    }

    private function ensureAliasIsValid(string $alias) {
        if (empty($alias)) {
            throw new InvalidArgumentException('Alias is required');
        }
    }


}
