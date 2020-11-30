<?php

namespace Notify\Tests\Envelope\Stamp;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\ReplayStamp;
use Notify\Envelope\Stamp\HandlerStamp;
use PHPUnit\Framework\TestCase;

final class RendererStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $stamp        = new HandlerStamp('toastr');

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Notify\Envelope\Stamp\HandlerStamp'));
        $this->assertInstanceOf('Notify\Envelope\Stamp\HandlerStamp', $stamp);
        $this->assertSame('toastr', $stamp->getHandler());
    }
}
