<?php

namespace Yoeunes\Notify\Tests\Envelope\Stamp;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\TimeStamp;
use PHPUnit\Framework\TestCase;

final class TimeStampTest extends TestCase
{
    public function test___construct()
    {
        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamp = new TimeStamp();

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Yoeunes\Notify\Envelope\Stamp\TimeStamp'));
        $this->assertInstanceOf('\Yoeunes\Notify\Envelope\Stamp\StampInterface', $stamp);
    }
}
