<?php

namespace Notify\Tests\Envelope\Stamp;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\ReplayStamp;
use PHPUnit\Framework\TestCase;

final class LifeStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $stamp        = new ReplayStamp(5);

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Notify\Envelope\Stamp\ReplayStamp'));
        $this->assertInstanceOf('Notify\Envelope\Stamp\ReplayStamp', $stamp);
        $this->assertSame(5, $stamp->getCount());
    }
}
