<?php

namespace Notify\Tests\Filter;

use Notify\Config\Config;
use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\PriorityStamp;
use Notify\Filter\DefaultFilter;
use Notify\Filter\FilterBuilder;
use Notify\Middleware\AddCreatedAtStampMiddleware;
use Notify\Middleware\AddPriorityStampMiddleware;
use Notify\Middleware\MiddlewareManager;
use Notify\Tests\TestCase;

final class DefaultFilterTest extends TestCase
{
    public function testWithCriteria()
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

        $config = new Config(array(
            'default' => 'notify',
            'adapters' => array(
                'notify' => array(
                    'scripts' => array('script.js'),
                    'styles' => array('styles.css'),
                    'options' => array()
                )
            ),
            'stamps_middlewares' => array(
                new AddPriorityStampMiddleware(),
                new AddCreatedAtStampMiddleware(),
            )
        ));

        $middleware     = new MiddlewareManager($config);

        $envelopes = $middleware->handleMany($notifications);

        $defaultFilter = new DefaultFilter(new FilterBuilder());
        $defaultFilter->filter($envelopes, array(
            'priority' => 2,
        ));

        $this->assertNotEmpty($envelopes);
    }
}
