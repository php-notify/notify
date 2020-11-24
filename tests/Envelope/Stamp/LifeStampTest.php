<?php

namespace Notify\Tests\Envelope\Stamp;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\LifeStamp;
use PHPUnit\Framework\TestCase;

final class LifeStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $stamp        = new LifeStamp(5);

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Notify\Envelope\Stamp\LifeStamp'));
        $this->assertInstanceOf('Notify\Envelope\Stamp\LifeStamp', $stamp);
        $this->assertSame(5, $stamp->getLife());
    }
}
