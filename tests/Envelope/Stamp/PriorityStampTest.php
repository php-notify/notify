<?php

namespace Notify\Tests\Envelope\Stamp;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\LifeStamp;
use Notify\Envelope\Stamp\PriorityStamp;
use PHPUnit\Framework\TestCase;

final class PriorityStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $stamp        = new PriorityStamp(5);

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Notify\Envelope\Stamp\PriorityStamp'));
        $this->assertInstanceOf('Notify\Envelope\Stamp\StampInterface', $stamp);
        $this->assertSame(5, $stamp->getPriority());
    }

    public function testCompare()
    {
        $stamp1 = new PriorityStamp(1);
        $stamp2 = new PriorityStamp(2);

        $this->assertFalse($stamp1->compare($stamp2));
        $this->assertSame(0, $stamp1->compare(new LifeStamp(1)));
    }
}
