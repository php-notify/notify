<?php

namespace Notify\Tests\Envelope;

use Notify\Envelope\Envelope;
use PHPUnit\Framework\TestCase;

final class EnvelopeTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $stamp        = $this->getMockBuilder('Notify\Envelope\Stamp\StampInterface')->getMock();

        $envelope = new Envelope($notification, array($stamp));

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertSame(array(get_class($stamp) => $stamp), $envelope->all());
    }

    public function testWith()
    {
        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $stamp_1        = $this->getMockBuilder('Notify\Envelope\Stamp\StampInterface')->getMock();
        $stamp_2        = $this->getMockBuilder('Notify\Envelope\Stamp\StampInterface')->getMock();

        $envelope = new Envelope($notification);
        $envelope->with($stamp_1, $stamp_2);

        $this->assertSame($notification, $envelope->getNotification());

        $this->assertSame(array(get_class($stamp_1) => $stamp_1, get_class($stamp_2) => $stamp_2), $envelope->all());
    }

    public function testWrap()
    {
        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $stamp        = $this->getMockBuilder('Notify\Envelope\Stamp\StampInterface')->getMock();

        $envelope = Envelope::wrap($notification, array($stamp));

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertSame(array(get_class($stamp) => $stamp), $envelope->all());
    }

    public function testAll()
    {
        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $stamps       = array(
            $this->getMockBuilder('Notify\Envelope\Stamp\StampInterface')->getMock(),
            $this->getMockBuilder('Notify\Envelope\Stamp\StampInterface')->getMock(),
            $this->getMockBuilder('Notify\Envelope\Stamp\StampInterface')->getMock(),
            $this->getMockBuilder('Notify\Envelope\Stamp\StampInterface')->getMock(),
        );

        $envelope = new Envelope($notification, $stamps);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertSame(array(get_class($stamps[0]) => $stamps[3]), $envelope->all());
    }

    public function testGet()
    {
        $notification = $this->getMockBuilder('\Notify\Notification\NotificationInterface')->getMock();
        $stamps       = array(
            $this->getMockBuilder('Notify\Envelope\Stamp\StampInterface')->getMock(),
            $this->getMockBuilder('Notify\Envelope\Stamp\StampInterface')->getMock(),
            $this->getMockBuilder('Notify\Envelope\Stamp\StampInterface')->getMock(),
        );

        $envelope = new Envelope($notification, $stamps);

        $this->assertSame($notification, $envelope->getNotification());

        $last = $envelope->get(get_class($stamps[0]));

        $this->assertSame($stamps[2], $last);
        $this->assertSame($last, $envelope->get(get_class($stamps[0])));

        $this->assertNull($envelope->get('NotFoundStamp'));
    }
}
