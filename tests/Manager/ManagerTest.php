<?php

namespace Notify\Tests\Manager;

use Notify\Producer\ProducerManager;
use Notify\Tests\TestCase;

final class ManagerTest extends TestCase
{
    public function testDefaultDriver()
    {
        $config = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('default')
            ->willReturn('default_notifier');

        $manager = new ProducerManager($config);
        $this->assertEquals('default_notifier', $manager->getDefaultDriver());
    }

    public function testMakeDriver()
    {
        $config = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('default')
            ->willReturn('default_notifier');

        $manager = new ProducerManager($config);

        $producer = $this->getMockBuilder('Notify\Producer\ProducerInterface')->getMock();
        $producer->method('supports')->willReturn(true);
        $manager->addDriver($producer);

        $this->assertSame($producer, $manager->make('fake'));
    }

    public function testDriverNotSupported()
    {
        $this->setExpectedException('InvalidArgumentException', 'Driver [test_driver] not supported.');

        $config = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('default')
            ->willReturn('default_notifier');

        $manager = new ProducerManager($config);

        $producer = $this->getMockBuilder('Notify\Producer\ProducerInterface')->getMock();
        $manager->addDriver($producer);

        $manager->make('test_driver');
    }
}
