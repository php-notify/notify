<?php

namespace Notify\Storage;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\CreatedAtStamp;
use Notify\Envelope\Stamp\LifeStamp;
use Notify\Envelope\Stamp\UuidStamp;

class ArrayStorage implements StorageInterface
{
    /**
     * @var Envelope[]
     */
    private $envelopes = array();

    /**
     * @inheritDoc
     */
    public function get()
    {
        return $this->envelopes;
    }

    /**
     * @inheritDoc
     */
    public function add(Envelope $envelope)
    {
        if (null === $envelope->get('Notify\Envelope\Stamp\UuidStamp')) {
            $envelope->withStamp(new UuidStamp());
        }

        if (null === $envelope->get('Notify\Envelope\Stamp\LifeStamp')) {
            $envelope->withStamp(new LifeStamp(1));
        }

        if (null === $envelope->get('Notify\Envelope\Stamp\CreatedAtStamp')) {
            $envelope->withStamp(new CreatedAtStamp());
        }

        $this->envelopes[] = $envelope;
    }

    public function flush($envelopes)
    {
        $envelopesMap = array();

        foreach ($envelopes as $envelope) {
            $life = $envelope->get('Notify\Envelope\Stamp\LifeStamp')->getLife();
            $uuid = $envelope->get('Notify\Envelope\Stamp\UuidStamp')->getUuid();

            $envelopesMap[$uuid] = $life;
        }

        $store = array();

        foreach ($this->get()as $envelope) {
            $uuid = $envelope->get('Notify\Envelope\Stamp\UuidStamp')->getUuid();

            if(isset($envelopesMap[$uuid])) {
                $life = $envelopesMap[$uuid] - 1;

                if ($life <= 0) {
                    continue;
                }

                $envelope->with(new LifeStamp($life));
            }

            $store[] = $envelope;
        }

        $this->envelopes = $store;
    }
}
