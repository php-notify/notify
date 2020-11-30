<?php

namespace Notify\Storage;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\UuidStamp;

final class ArrayStorage implements StorageInterface
{
    /**
     * @var Envelope[]
     */
    private $envelopes = array();

    /**
     * @inheritDoc
     */
    public function all()
    {
        return $this->envelopes;
    }

    /**
     * @inheritDoc
     */
    public function add($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        foreach ($envelopes as $envelope) {
            if (null === $envelope->get('Notify\Envelope\Stamp\UuidStamp')) {
                $envelope->withStamp(new UuidStamp());
            }

            $this->envelopes[] = $envelope;
        }
    }

    /**
     * @param \Notify\Envelope\Envelope[] $envelopes
     */
    public function remove($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $map = UuidStamp::indexWithUuid($envelopes);

        $this->envelopes = array_filter($this->envelopes, function (Envelope $envelope) use ($map) {
            $uuid = $envelope->get('Notify\Envelope\Stamp\UuidStamp')->getUuid();

            return !isset($map[$uuid]);
        });
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->envelopes = array();
    }
}
