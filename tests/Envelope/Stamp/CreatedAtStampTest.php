<?php

namespace Notify\Tests\Envelope\Stamp;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\CreatedAtStamp;
use Notify\Envelope\Stamp\LifeStamp;
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

    public function testCompare()
    {
        $createdAt1 = new CreatedAtStamp(new \DateTime('+2 h'));
        $createdAt2 = new CreatedAtStamp(new \DateTime('+1 h'));

        $this->assertFalse($createdAt1->compare($createdAt2));
        $this->assertSame(0, $createdAt1->compare(new LifeStamp(1)));
    }
}
