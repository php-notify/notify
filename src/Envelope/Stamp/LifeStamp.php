<?php

namespace Notify\Envelope\Stamp;

final class LifeStamp implements StampInterface
{
    /**
     * @var int
     */
    private $life;

    public function __construct($life)
    {
        $this->life = $life;
    }

    /**
     * @return int
     */
    public function getLife()
    {
        return $this->life;
    }
}
