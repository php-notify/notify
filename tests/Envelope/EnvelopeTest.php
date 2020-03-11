<?php

namespace Yoeunes\Notify\Tests\Envelope;

use Yoeunes\Notify\Envelope\Envelope;
use PHPUnit\Framework\TestCase;

final class EnvelopeTest extends TestCase
{
    public function test___construct()
    {
        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamp = $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock();

        $envelope = new Envelope($notification, array($stamp));

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertSame(array(get_class($stamp) => $stamp), $envelope->all());
    }

    public function test_with()
    {
        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamp = $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock();

        $envelope = new Envelope($notification);
        $envelope->with($stamp);

        $this->assertSame($notification, $envelope->getNotification());

        $this->assertSame(array(get_class($stamp) => $stamp), $envelope->all());
    }

    public function test_wrap()
    {
        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamp = $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock();

        $envelope = Envelope::wrap($notification, array($stamp));

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertSame(array(get_class($stamp) => $stamp), $envelope->all());
    }

    public function test_all()
    {
        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamps = array(
            $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock(),
            $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock(),
            $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock(),
            $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock(),
        );

        $envelope = new Envelope($notification, $stamps);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertSame(array(get_class($stamps[0]) => $stamps[3]), $envelope->all());
    }

    public function test_get()
    {
        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamps = array(
            $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock(),
            $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock(),
            $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock(),
        );

        $envelope = new Envelope($notification, $stamps);

        $this->assertSame($notification, $envelope->getNotification());

        $last = $envelope->get(get_class($stamps[0]));

        $this->assertSame($stamps[2], $last);
        $this->assertSame($last, $envelope->get(get_class($stamps[0])));

        $this->assertNull($envelope->get('NotFoundStamp'));
    }
}
