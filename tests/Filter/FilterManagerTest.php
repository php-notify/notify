<?php

namespace Notify\Tests\Filter;

use Notify\Config\Config;
use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\PriorityStamp;
use Notify\Filter\FilterBuilder;
use Notify\Filter\Specification\PrioritySpecification;
use Notify\Middleware\AddCreatedAtStampMiddleware;
use Notify\Middleware\AddPriorityStampMiddleware;
use Notify\Middleware\NotifyBus;
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

        $middleware     = new NotifyBus($config);

        $envelopes = array();
        foreach ($notifications as $notification) {
            $envelopes[] = $middleware->dispatch($notification);
        }

        $builder = new FilterBuilder();

        $envelopes = $builder
            ->andWhere(new PrioritySpecification(1))
            ->andWhere(New PrioritySpecification(1, 5))
            ->orderBy(array(
                'Notify\Envelope\Stamp\PriorityStamp' => 'ASC'
            ))
            ->setMaxResults(2)
            ->filter($envelopes)
        ;

        $this->assertNotEmpty($envelopes);

        $builder = new FilterBuilder();

        $envelopes = $builder
            ->orWhere(new PrioritySpecification(1))
            ->orWhere(New PrioritySpecification(1, 5))
            ->orderBy(array(
                'Notify\Envelope\Stamp\PriorityStamp' => 'ASC',
                'Notify\Envelope\Stamp\NotExists' => 'ASC',
            ))
            ->setMaxResults(2)
            ->filter($envelopes)
        ;

        $this->assertNotEmpty($envelopes);

        $builder = new FilterBuilder();
        $builder->withCriteria(array(
            'priority' => '1'
        ));

        $envelopes = $builder->filter($envelopes);
        $this->assertNotEmpty($envelopes);
    }
}
