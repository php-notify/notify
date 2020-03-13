<?php

namespace Yoeunes\Notify\Tests\Producer;

use Yoeunes\Notify\Producer\ProducerManager;
use Yoeunes\Notify\Tests\TestCase;

final class ProducerManagerTest extends TestCase
{
    public function test_extend_to_add_more_notifiers_factory()
    {
        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $manager = new ProducerManager($config);

        $notifier = $this->getMockBuilder('Yoeunes\Notify\Producer\ProducerInterface')->getMock();

        $manager->extend(
            'notifier_1',
            function () use ($notifier) {
                return $notifier;
            }
        );

        $manager->extend('notifier_2', $this->getMockBuilder('Yoeunes\Notify\Producer\ProducerInterface'));

        $reflection = new \ReflectionClass(get_class($manager));
        $extensions = $reflection->getProperty('customCreators');
        $extensions->setAccessible(true);

        $this->assertCount(2, $extensions->getValue($manager));
        $this->assertCount(0, $manager->getDrivers());
    }
}
