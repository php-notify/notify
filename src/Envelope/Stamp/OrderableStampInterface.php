<?php

namespace Notify\Envelope\Stamp;

interface OrderableStampInterface
{
    /**
     * @param \Notify\Envelope\Stamp\OrderableStampInterface $orderable
     *
     * @return int
     */
    public function compare($orderable);
}
