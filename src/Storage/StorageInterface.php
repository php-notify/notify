<?php

namespace Notify\Storage;

interface StorageInterface
{
    /**
     * @return \Notify\Envelope\Envelope[]
     */
    public function all();

    /**
     * @param \Notify\Envelope\Envelope|\Notify\Envelope\Envelope[] $envelopes
     */
    public function add($envelopes);

    /**
     * @param \Notify\Envelope\Envelope|\Notify\Envelope\Envelope[] $envelopes
     */
    public function remove($envelopes);

    /**
     * Remove all notifications from the storage
     */
    public function clear();
}
