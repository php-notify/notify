<?php

namespace Notify\Tests\Envelope\Stamp;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\UuidStamp;
use PHPUnit\Framework\TestCase;

final class UuidStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $stamp        = new UuidStamp();

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Notify\Envelope\Stamp\UuidStamp'));
        $this->assertInstanceOf('Notify\Envelope\Stamp\UuidStamp', $stamp);
        $this->assertNotEmpty($stamp->getUuid());
    }
}
