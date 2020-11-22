<?php

namespace Notify\Storage;

use Notify\Envelope\Envelope;

interface StorageInterface
{
    /**
     * @return Envelope[]
     */
    public function get();

    /**
     * @param \Notify\Envelope\Envelope $envelope
     */
    public function add(Envelope $envelope);

    /**
     * @param Envelope[] $envelopes
     */
    public function flush($envelopes);
}
