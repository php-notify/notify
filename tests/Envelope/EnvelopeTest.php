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
        $this->assertSame(array(get_class($stamp) => array($stamp)), $envelope->all());
    }

    public function test_with()
    {
        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamp = $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock();

        $envelope = new Envelope($notification);
        $anotherEnvelop = $envelope->with(array($stamp));

        $this->assertNotSame($envelope, $anotherEnvelop);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertSame($notification, $anotherEnvelop->getNotification());

        $this->assertSame(array(), $envelope->all());
        $this->assertSame(array(get_class($stamp) => array($stamp)), $anotherEnvelop->all());
    }

    public function test_wrap()
    {
        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamp = $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock();

        $envelope = Envelope::wrap($notification, array($stamp));

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertSame(array(get_class($stamp) => array($stamp)), $envelope->all());
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
        $this->assertSame(array(get_class($stamps[0]) => $stamps), $envelope->all());
    }

    public function test_last()
    {
        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamps = array(
            $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock(),
            $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock(),
            $this->getMockBuilder('\Yoeunes\Notify\Envelope\Stamp\StampInterface')->getMock(),
        );

        $envelope = new Envelope($notification, $stamps);

        $this->assertSame($notification, $envelope->getNotification());

        $last = $envelope->last(get_class($stamps[0]));

        $this->assertNotSame($stamps[0], $last);
        $this->assertNotSame($stamps[1], $last);
        $this->assertSame($stamps[2], $last);
        $this->assertSame($last, $envelope->last(get_class($stamps[0])));

        $this->assertNull($envelope->last('NotFoundStamp'));
    }
}
