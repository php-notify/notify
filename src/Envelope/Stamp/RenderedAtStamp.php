<?php

namespace Notify\Envelope\Stamp;

final class RenderedAtStamp implements StampInterface
{
    /**
     * @param \DateTime
     */
    private $renderedAt;

    /**
     * @param \DateTime|null $renderedAt
     *
     * @throws \Exception
     */
    public function __construct(\DateTime $renderedAt = null)
    {
        $this->renderedAt = $renderedAt ?: new \DateTime('now', new \DateTimeZone('Africa/Casablanca'));
    }

    /**
     * @return \DateTime
     */
    public function getRenderedAt()
    {
        return $this->renderedAt;
    }
}
