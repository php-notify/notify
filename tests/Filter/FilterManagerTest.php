<?php

namespace Yoeunes\Notify\Tests\Filter;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\PriorityStamp;
use Yoeunes\Notify\Storage\Filter\FilterBuilder;
use PHPUnit\Framework\TestCase;
use Yoeunes\Notify\Storage\Filter\Specification\TimeSpecification;
use Yoeunes\Notify\Middleware\AddPriorityStampMiddleware;
use Yoeunes\Notify\Middleware\AddCreatedAtStampMiddleware;
use Yoeunes\Notify\Middleware\MiddlewareManager;

final class FilterManagerTest extends TestCase
{
    public function test_filter_where()
    {
        $notifications = array(
            $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock(),
            $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock(),
            $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock(),
        );

        $notifications[3] = new Envelope(
            $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock(),
            array(new PriorityStamp(5))
        );

        $notifications[4] = new Envelope(
            $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock(),
            array(new PriorityStamp(-1))
        );

        $notifications[5] = new Envelope(
            $this->getMockBuilder('\Yoeunes\Notify\Notification\NotificationInterface')->getMock(),
            array(new PriorityStamp(1))
        );

        $middlewareList = array(
            new AddPriorityStampMiddleware(),
            new AddCreatedAtStampMiddleware(),
        );
        $middleware = new MiddlewareManager($middlewareList);

        $envelopes = $middleware->handleMany($notifications);

        $builder = new FilterBuilder();

        $envelopes = $builder
//            ->wherePriority(-1, 1)
//            ->andWhere(new TimeSpecification(new \DateTime()))
            ->setMaxResults(2)
            ->filter($envelopes);

        $this->assertNotEmpty($envelopes);
    }
}
