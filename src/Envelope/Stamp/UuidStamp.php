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
            random_int(0, 65535),
            random_int(0, 65535),
            random_int(0, 65535),
            random_int(16384, 20479),
            random_int(32768, 49151),
            random_int(0, 65535),
            random_int(0, 65535),
            random_int(0, 65535)
        );
    }

    public function getUuid()
    {
        return $this->uuid;
    }
}
