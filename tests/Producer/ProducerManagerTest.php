<?php

namespace Notify\Tests\Producer;

use Notify\Producer\ProducerManager;
use Notify\Tests\TestCase;
use ReflectionClass;

final class ProducerManagerTest extends TestCase
{
    public function testExtendToAddMoreNotifiersFactory()
    {
        $config  = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $manager = new ProducerManager($config);

        $notifier = $this->getMockBuilder('Notify\Producer\ProducerInterface')->getMock();
        $manager->addDriver('notifier_1', static function () use ($notifier) {
            return $notifier;
        });

        $manager->addDriver('notifier_2', $this->getMockBuilder('Notify\Producer\ProducerInterface'));

        $reflection = new ReflectionClass(get_class($manager));
        $extensions = $reflection->getProperty('drivers');
        $extensions->setAccessible(true);

        $this->assertCount(2, $extensions->getValue($manager));
    }
}
