<?php

namespace Yoeunes\Notify\Envelope\Stamp;

final class FingerprintStamp implements StampInterface
{
    /**
     * @var string
     */
    private $fingerprint;

    public function __construct($fingerprint)
    {
        $this->fingerprint = $fingerprint;
    }

    /**
     * @return string
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }
}
