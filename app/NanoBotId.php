<?php

namespace App;

class NanoBotId
{
    /**
     * @var int
     */
    private $id;

    public static function fromInt(int $id)
    {
        self::ensureIsValid($id);

        return new self($id);
    }

    private function __construct(int $id)
    {
        $this->id = $id;
    }

    public function toInt(): int
    {
        return $this->id;
    }

    private static function ensureIsValid(int $id)
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Invalid NanoBotId q given');
        }
    }
}
