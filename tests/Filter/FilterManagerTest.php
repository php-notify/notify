<?php

namespace Notify\Tests\Filter;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\PriorityStamp;
use Notify\Middleware\AddCreatedAtStampMiddleware;
use Notify\Middleware\AddPriorityStampMiddleware;
use Notify\Middleware\MiddlewareManager;
use Notify\Filter\FilterBuilder;
use PHPUnit\Framework\TestCase;

final class FilterManagerTest extends TestCase
{
    public function testFilterWhere()
    {
        $notifications = array(
            $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock(),
            $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock(),
            $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock(),
        );

        $notifications[3] = new Envelope(
            $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock(),
            array(new PriorityStamp(5))
        );

        $notifications[4] = new Envelope(
            $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock(),
            array(new PriorityStamp(-1))
        );

        $notifications[5] = new Envelope(
            $this->getMockBuilder('Notify\Notification\NotificationInterface')->getMock(),
            array(new PriorityStamp(1))
        );

        $middlewareList = array(
            new AddPriorityStampMiddleware(),
            new AddCreatedAtStampMiddleware(),
        );
        $middleware     = new MiddlewareManager($middlewareList);

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
