<?php

namespace Notify\Envelope\Stamp;

final class UuidStamp implements StampInterface
{
    /**
     * @var string
     */
    private $uuid;

    public function __construct()
    {
        $this->uuid = sprintf(
            '%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(16384, 20479),
            mt_rand(32768, 49151),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535)
        );
    }

    public function getUuid()
    {
        return $this->uuid;
    }
}
