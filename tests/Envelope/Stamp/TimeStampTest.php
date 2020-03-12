<?php

namespace Yoeunes\Notify\Tests\Envelope\Stamp;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\CreatedAtStamp;
use PHPUnit\Framework\TestCase;

final class TimeStampTest extends TestCase
{
    public function test___construct()
    {
        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamp = new CreatedAtStamp();

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Yoeunes\Notify\Envelope\Stamp\CreatedAtStamp'));
        $this->assertInstanceOf('\Yoeunes\Notify\Envelope\Stamp\StampInterface', $stamp);
    }
}
