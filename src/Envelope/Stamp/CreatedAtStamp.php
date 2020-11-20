<?php

namespace Notify\Envelope\Stamp;

use DateTime;

final class CreatedAtStamp implements StampInterface
{
    /**
     * @param int
     */
    private $createdAt;

    public function __construct(DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt ?: new DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
