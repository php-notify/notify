<?php

namespace Notify\Storage;

use Notify\Envelope\Envelope;

interface StorageManagerInterface
{
    /**
     * @param \Notify\Envelope\Envelope[] $envelopes
     */
    public function flush($envelopes);

    /**
     * @return \Notify\Envelope\Envelope[]
     */
    public function all();

    /**
     * @param \Notify\Envelope\Envelope $envelope
     */
    public function add(Envelope $envelope);

    /**
     * @param \Notify\Envelope\Envelope[] $envelopes
     */
    public function remove($envelopes);

    /**
     * remove All notifications from storage
     */
    public function clear();
}
