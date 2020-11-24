<?php

namespace Notify\Tests\Stubs\Producer;

use Notify\Manager\AbstractManager;
use Notify\Producer\AbstractProducer;

class FakeProducer extends AbstractProducer
{
    public function getRenderer()
    {
        return 'fake';
    }
}
