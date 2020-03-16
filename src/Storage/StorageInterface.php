<?php

namespace Yoeunes\Notify\Storage;

use Yoeunes\Notify\Envelope\Envelope;

interface StorageInterface
{
    public function get();

    public function add(Envelope $envelope);
}
