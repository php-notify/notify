<?php

namespace Notify\Tests\Envelope\Stamp;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\LifeStamp;
use Notify\Envelope\Stamp\RendererStamp;
use PHPUnit\Framework\TestCase;

final class RendererStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $stamp        = new RendererStamp('toastr');

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Notify\Envelope\Stamp\RendererStamp'));
        $this->assertInstanceOf('Notify\Envelope\Stamp\RendererStamp', $stamp);
        $this->assertSame('toastr', $stamp->getRenderer());
    }
}
