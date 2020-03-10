<?php

namespace Yoeunes\Notify\Envelope\Stamp;

final class DelayStamp implements StampInterface
{
    /**
     * @param  int
     */
    private $delay;

    /**
     * @param  int  $delay  The delay in milliseconds
     */
    public function __construct($delay)
    {
        $this->delay = $delay;
    }

    /**
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }
}
