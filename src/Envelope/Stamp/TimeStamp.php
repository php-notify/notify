<?php

namespace Yoeunes\Notify\Envelope\Stamp;

final class TimeStamp implements StampInterface
{
    /**
     * @param  int
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
