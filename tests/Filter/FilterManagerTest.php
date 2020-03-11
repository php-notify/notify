<?php

namespace Yoeunes\Notify\Tests\Filter;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\PriorityStamp;
use Yoeunes\Notify\Filter\FilterManager;
use PHPUnit\Framework\TestCase;
use Yoeunes\Notify\Filter\Specification\AndSpecification;
use Yoeunes\Notify\Filter\Specification\PrioritySpecification;
use Yoeunes\Notify\Filter\Specification\TimeSpecification;
use Yoeunes\Notify\Middleware\AddPriorityStampMiddleware;
use Yoeunes\Notify\Middleware\AddTimeStampMiddleware;
use Yoeunes\Notify\Middleware\MiddlewareStack;

final class FilterManagerTest extends TestCase
{
    public function test_filter()
    {
        $middlewareList = array(
            new AddPriorityStampMiddleware(),
            new AddTimeStampMiddleware(),
        );

        $manager = new FilterManager(new MiddlewareStack($middlewareList));

        $specifications = array(
            new PrioritySpecification(-1, 0),
            new TimeSpecification(new \DateTime())
        );

        $specification = new AndSpecification($specifications);

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

        $expected = array(
            $notifications[3]->getNotification(),
            $notifications[5]->getNotification(),
        );

        var_dump($manager->filter($notifications, $specification));
//        $this->assertEquals($expected, $manager->filter($notifications, $specification));
    }
}
