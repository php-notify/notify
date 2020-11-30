<?php

namespace Notify\Envelope\Stamp;

final class UuidStamp implements StampInterface
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @param string|null $uuid
     */
    public function __construct($uuid = null)
    {
        $this->uuid = $uuid ?: sprintf(
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

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param \Notify\Envelope\Envelope|\Notify\Envelope\Envelope[] $envelopes
     *
     * @return array<string, \Notify\Envelope\Envelope>
     */
    public static function indexWithUuid($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $map = array();

        foreach ($envelopes as $envelope) {
            $uuid = $envelope->get('Notify\Envelope\Stamp\UuidStamp')->getUuid();

            $map[$uuid] = $envelope;
        }

        return $map;
    }
}
