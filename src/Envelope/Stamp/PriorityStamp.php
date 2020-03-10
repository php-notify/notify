<?php

namespace Yoeunes\Notify\Envelope\Stamp;

final class PriorityStamp implements StampInterface
{
    /**
     * @var int
     */
    private $priority;

    public function __construct($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
