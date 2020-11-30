<?php

namespace Notify\Tests\Stubs\Producer;

use Notify\Producer\AbstractProducer;

class FakeProducer extends AbstractProducer
{
    public function supports($name = null, array $context = array())
    {
        return in_array($name, array('fake', __CLASS__));
    }
}
