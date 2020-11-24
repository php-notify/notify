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

        $producer = $this->getMockBuilder('Notify\Producer\ProducerInterface')->getMock();
        $manager->addDriver('producer_1', $producer);

        $manager->addDriver('producer_2', $this->getMockBuilder('Notify\Producer\ProducerInterface'));

        $reflection = new ReflectionClass(get_class($manager));
        $extensions = $reflection->getProperty('drivers');
        $extensions->setAccessible(true);

        $this->assertCount(2, $extensions->getValue($manager));

        $this->assertSame($producer, $manager->make('producer_1'));
    }

    public function testNullDriver()
    {
        $this->setExpectedException('InvalidArgumentException', 'Unable to resolve NULL driver for [Notify\Producer\ProducerManager].');

        $config  = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $config->method('get')->willReturn(null);

        $manager = new ProducerManager($config);

        $producer = $this->getMockBuilder('Notify\Producer\ProducerInterface')->getMock();
        $manager->addDriver('producer_1', $producer);

        $this->assertSame($producer, $manager->make());
    }

    public function testNotSupportedDriver()
    {
        $this->setExpectedException('InvalidArgumentException', 'Driver [not_supported] not supported.');

        $config  = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $manager = new ProducerManager($config);

        $producer = $this->getMockBuilder('Notify\Producer\ProducerInterface')->getMock();
        $manager->addDriver('producer_1', $producer);

        $this->assertSame($producer, $manager->make('not_supported'));
    }
}
