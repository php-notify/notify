<?php

namespace Notify\Tests\Envelope\Stamp;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\CreatedAtStamp;
use PHPUnit\Framework\TestCase;

final class CreatedAtStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $stamp        = new CreatedAtStamp();

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Notify\Envelope\Stamp\CreatedAtStamp'));
        $this->assertInstanceOf('Notify\Envelope\Stamp\StampInterface', $stamp);
    }
}
