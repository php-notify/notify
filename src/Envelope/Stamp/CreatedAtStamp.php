<?php

namespace Notify\Envelope\Stamp;

final class CreatedAtStamp implements StampInterface, OrderableStampInterface
{
    /**
     * @param int
     */
    private $createdAt;

    public function __construct(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt ?: new \DateTime('now', new \DateTimeZone('Africa/Casablanca'));
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function compare($orderable)
    {
        if (!$orderable instanceof CreatedAtStamp) {
            return 0;
        }

        return $this->createdAt > $orderable->createdAt;
    }
}
