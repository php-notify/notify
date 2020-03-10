<?php

namespace Yoeunes\Notify\Tests\Envelope\Stamp;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\PriorityStamp;
use PHPUnit\Framework\TestCase;

final class PriorityStampTest extends TestCase
{
    public function test___construct()
    {
        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamp = new PriorityStamp(5);

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->last('Yoeunes\Notify\Envelope\Stamp\PriorityStamp'));
        $this->assertInstanceOf('\Yoeunes\Notify\Envelope\Stamp\StampInterface', $stamp);
    }
}
