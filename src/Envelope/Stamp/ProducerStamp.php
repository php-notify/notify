<?php

namespace Yoeunes\Notify\Envelope\Stamp;

final class ProducerStamp implements StampInterface
{
    /**
     * @var string
     */
    private $producer;

    public function __construct($producer)
    {
        $this->producer = $producer;
    }

    /**
     * @return string
     */
    public function getProducer()
    {
        return $this->producer;
    }
}
