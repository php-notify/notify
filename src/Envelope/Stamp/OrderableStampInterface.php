<?php

namespace Notify\Envelope\Stamp;

interface OrderableStampInterface
{
    public function compare($orderable);
}
