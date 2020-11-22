<?php

namespace Notify\Tests\Middleware;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\PriorityStamp;
use Notify\Middleware\AddCreatedAtStampMiddleware;
use Notify\Middleware\AddPriorityStampMiddleware;
use Notify\Middleware\MiddlewareManager;
use PHPUnit\Framework\TestCase;

final class MiddlewareStackTest extends TestCase
{
    public function testHandle()
    {
        $middlewareList = array(
            new AddPriorityStampMiddleware(),
            new AddCreatedAtStampMiddleware(),
        );

        $stack = new MiddlewareManager($middlewareList);

        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $envelope     = new Envelope($notification);

        $stack->handle($envelope);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertCount(3, $envelope->all());

        $priorityStamp = $envelope->get('Notify\Envelope\Stamp\PriorityStamp');
        $this->assertInstanceOf('Notify\Envelope\Stamp\PriorityStamp', $priorityStamp);
//        $this->assertEquals(0, $priorityStamp->getPriority());

        $timeStamp = $envelope->get('Notify\Envelope\Stamp\CreatedAtStamp');
        $this->assertInstanceOf('Notify\Envelope\Stamp\CreatedAtStamp', $timeStamp);

        $this->assertEquals(time(), $timeStamp->getCreatedAt()->getTimestamp());
    }

    public function testHandleWithExistingStamps()
    {
        $middlewareList = array(
            new AddPriorityStampMiddleware(),
        );

        $stack = new MiddlewareManager($middlewareList);

        $notification = $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock();
        $stamps       = array(
            new PriorityStamp(1),
        );
        $envelope     = new Envelope($notification, $stamps);

        $stack->handle($envelope);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertCount(3, $envelope->all());

        $priorityStamp = $envelope->get('Notify\Envelope\Stamp\PriorityStamp');
        $this->assertInstanceOf('Notify\Envelope\Stamp\PriorityStamp', $priorityStamp);
//        $this->assertEquals(1, $priorityStamp->getPriority());
    }
}
