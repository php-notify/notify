<?php

namespace Yoeunes\Notify\Tests\Middleware;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\PriorityStamp;
use Yoeunes\Notify\Middleware\AddDelayStampMiddleware;
use Yoeunes\Notify\Middleware\AddPriorityStampMiddleware;
use Yoeunes\Notify\Middleware\AddCreatedAtStampMiddleware;
use Yoeunes\Notify\Middleware\MiddlewareManager;
use PHPUnit\Framework\TestCase;

final class MiddlewareStackTest extends TestCase
{
    public function test_handle()
    {
        $middlewareList = array(
            new AddPriorityStampMiddleware(),
            new AddCreatedAtStampMiddleware(),
        );

        $stack = new MiddlewareManager($middlewareList);

        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $envelope = new Envelope($notification);

        $stack->handle($envelope);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertCount(2, $envelope->all());

        $priorityStamp = $envelope->get('Yoeunes\Notify\Envelope\Stamp\PriorityStamp');
        $this->assertInstanceOf('Yoeunes\Notify\Envelope\Stamp\PriorityStamp', $priorityStamp);
//        $this->assertEquals(0, $priorityStamp->getPriority());

        $timeStamp = $envelope->get('Yoeunes\Notify\Envelope\Stamp\CreatedAtStamp');
        $this->assertInstanceOf('Yoeunes\Notify\Envelope\Stamp\CreatedAtStamp', $timeStamp);

        $this->assertEquals(time(), $timeStamp->getCreatedAt()->getTimestamp());
    }

    public function test_handle_with_existing_stamps()
    {
        $middlewareList = array(
            new AddPriorityStampMiddleware(),
        );

        $stack = new MiddlewareManager($middlewareList);

        $notification = $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock();
        $stamps = array(
            new PriorityStamp(1)
        );
        $envelope = new Envelope($notification, $stamps);

        $stack->handle($envelope);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertCount(1, $envelope->all());

        $priorityStamp = $envelope->get('Yoeunes\Notify\Envelope\Stamp\PriorityStamp');
        $this->assertInstanceOf('Yoeunes\Notify\Envelope\Stamp\PriorityStamp', $priorityStamp);
//        $this->assertEquals(1, $priorityStamp->getPriority());
    }
}
