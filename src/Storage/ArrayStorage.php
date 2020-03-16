<?php

namespace Yoeunes\Notify\Storage;

use Yoeunes\Notify\Envelope\Envelope;

class ArrayStorage implements StorageInterface
{
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
