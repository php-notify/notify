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

    public function testThrowExceptionWhenDriverNotFound()
    {
        $this->setExpectedException('InvalidArgumentException', 'Driver [default_notifier] not supported.');

        $config = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('drivers')
            ->willReturn(array());

        $manager = new ProducerManager($config);
        $this->callMethod($manager, 'createDriver', 'default_notifier');
    }

    public function testThrowExceptionForUnsupportedNotifier()
    {
        $this->setExpectedException('InvalidArgumentException', 'Driver [default_notifier] not supported.');

        $config = $this->getMockBuilder('\Notify\Config\ConfigInterface')->getMock();
        $config
            ->method('get')
            ->with('drivers')
            ->willReturn(
                array(
                    'default_notifier' => array(
                        'scripts' => array('jquery.js', 'default_notifier.js'),
                        'styles'  => array('default_notifier.css'),
                        'options' => array(),
                    ),
                )
            );

        $manager = new ProducerManager($config);
        $this->callMethod($manager, 'createDriver', 'default_notifier');
    }
}
