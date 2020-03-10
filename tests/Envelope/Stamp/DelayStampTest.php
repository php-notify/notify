<?php

namespace Yoeunes\Notify\Tests\Envelope\Stamp;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\DelayStamp;
use PHPUnit\Framework\TestCase;

final class DelayStampTest extends TestCase
{
    public function test___construct()
    {
        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamp = new DelayStamp(5);

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->last('Yoeunes\Notify\Envelope\Stamp\DelayStamp'));
        $this->assertInstanceOf('\Yoeunes\Notify\Envelope\Stamp\StampInterface', $stamp);
    }
}
