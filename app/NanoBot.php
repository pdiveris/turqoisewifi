<?php

namespace App;

/**
 * Class NanoBot
 *
 * @author Petros Diveris
 * @package App
 */
class NanoBot
{
    /**
     * @var NanoBotId
     */
    private $id;

    /**
     * Holds the x-axis position of the nanobot
     * @var $xPos
     */
    private $xPos = 0;

    /**
     * Holds the y-axis position of the nanobot
     *
     * @var $yPos
     */
    private $yPos = 0;

    /**
     * Holds the z-axis position of the nanobot
     *
     * @var int $zPos
     */
    private $zPos = 0;

    /**
     * Hold the range covered by the nanobot
     *
     * @var $range
     */
    private $range = 0;

    public static function create(NanoBotId $id, int $xPos, int $yPos, int $zPos, int $range): NanoBot
    {
        return new self(
            $id,
            $xPos,
            $yPos,
            $zPos,
            $range
        );
    }

    /**
     * Create abd populate with data
     *
     * @param array $state
     * @return NanoBot
     */
    public static function fromState(array $state): NanoBot
    {
        $id = is_int($state['id']) ? NanoBotId::fromInt($state['id']) : $state['id'];
        return new self(
            $id,
            $state['xPos'],
            $state['yPos'],
            $state['zPos'],
            $state['range']
        );
    }

    /**
     * NanoBot constructor.
     *
     * @param NanoBotId $id
     * @param int $xPos
     * @param int $yPos
     * @param int $zPos
     * @param int $range
     */
    public function __construct(NanoBotId $id, int $xPos = 0, int $yPos = 0, int $zPos = 0, int $range = 0)
    {
        $this->id = $id;
        $this->xPos = $xPos;
        $this->yPos = $yPos;
        $this->zPos = $zPos;
        $this->range = $range;
    }

    /**
     * @return NanoBotId
     */
    public function getId(): NanoBotId
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getXPos(): int
    {
        return $this->xPos;
    }

    /**
     * @param int $xPos
     * @return NanoBot
     */
    public function setX(int $xPos): NanoBot
    {
        $this->xPos = $xPos;
        return $this;
    }

    /**
     * @return int
     */
    public function getYPos(): int
    {
        return $this->yPos;
    }

    /**
     * @param int $yPos
     * @return NanoBot
     */
    public function setY(int $yPos): NanoBot
    {
        $this->yPos = $yPos;
        return $this;
    }

    /**
     * @return int
     */
    public function getZPos(): int
    {
        return $this->zPos;
    }

    /**
     * @param int $zPos
     * @return NanoBot
     */
    public function setZPos(int $zPos): NanoBot
    {
        $this->zPos = $zPos;
        return $this;
    }

    /**
     * @return int
     */
    public function getRange(): int
    {
        return $this->range;
    }

    /**
     * @param int $range
     * @return NanoBot
     */
    public function setRange(int $range): NanoBot
    {
        $this->range = $range;
        return $this;
    }

    /**
     * Find the number if nanboBots within the range of this bot
     *
     * @param NanoBotRepository $repository
     * @return int
     */
    public function inRange(NanoBotRepository $repository)
    {
        $nanoBots = $repository->all();
        $inRange = 0;
        foreach ($nanoBots as $nano) {
            $dist = abs($nano['xPos'] - $this->getXPos()) +
               abs($nano['yPos'] - $this->getYPos()) +
               abs($nano['zPos'] - $this->getZPos());

            if ($dist <= $this->getRange()) {
                $inRange++;
            }
        }
        return $inRange;
    }
}
