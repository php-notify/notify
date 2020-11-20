<?php

namespace Notify\Storage;

use Notify\Envelope\Envelope;

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
        $this->envelopes[] = $envelope;
    }
}
