<?php

namespace Flasher\Prime\Stamp;

final class PriorityStamp implements StampInterface, OrderableStampInterface
{
    /**
     * @var int
     */
    private $priority;

    /**
     * @param int $priority
     */
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

    /**
     * @param OrderableStampInterface $orderable
     *
     * @return int
     */
    public function compare($orderable)
    {
        if (!$orderable instanceof PriorityStamp) {
            return 0;
        }

        return $this->priority > $orderable->priority;
    }
}