<?php

namespace Yoeunes\Notify\Tests\Manager;

use Yoeunes\Notify\Producer\ProducerManager;
use Yoeunes\Notify\Tests\TestCase;

final class ManagerTest extends TestCase
{
    public function test_default_driver()
    {
        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('default')
            ->willReturn('default_notifier');

        $manager = new ProducerManager($config);
        $this->assertEquals('default_notifier', $manager->getDefaultDriver());
    }

    public function test_throw_exception_when_driver_not_found()
    {
        $this->setExpectedException('InvalidArgumentException', 'Driver [default_notifier] not configured');

        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('drivers')
            ->willReturn(array());

        $manager = new ProducerManager($config);
        $this->callMethod($manager, 'getDriverConfig', 'default_notifier');
    }

    public function test_throw_exception_when_driver_not_configured()
    {
        $this->setExpectedException('InvalidArgumentException', 'Driver [default_notifier] not configured');

        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();

        $manager = new ProducerManager($config);
        $this->callMethod($manager, 'getDriverConfig', 'default_notifier');
    }

    public function test_get_driver_config()
    {
        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $config
            ->expects($this->exactly(1))
            ->method('get')
            ->with('drivers')
            ->willReturn(
                array(
                    'default_notifier' => array(
                        'scripts' => array('jquery.js', 'default_notifier.js'),
                        'styles' => array('default_notifier.css'),
                        'options' => array(),
                    ),
                    'another_notifier' => array(
                        'css_classes' => array(
                            'success' => 'success',
                        ),
                    ),
                )
            );

        $manager = new ProducerManager($config);
        $this->assertEquals(
            array(
                'scripts' => array('jquery.js', 'default_notifier.js'),
                'styles' => array('default_notifier.css'),
                'options' => array(),
                'driver' => 'default_notifier',
            ),
            $this->callMethod($manager, 'getDriverConfig', 'default_notifier')
        );
    }

    public function test_throw_exception_for_unsupported_notifier()
    {
        $this->setExpectedException('InvalidArgumentException', 'Driver [default_notifier] not supported.');

        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $config
            ->method('get')
            ->with('drivers')
            ->willReturn(
                array(
                    'default_notifier' => array(
                        'scripts' => array('jquery.js', 'default_notifier.js'),
                        'styles' => array('default_notifier.css'),
                        'options' => array(),
                    ),
                )
            );

        $manager = new ProducerManager($config);
        $this->callMethod($manager, 'createDriver', 'default_notifier');
    }

    public function test_extend_to_add_more_notifiers_factory()
    {
        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $manager = new ProducerManager($config);

        $notifier = $this->getMockBuilder('Yoeunes\Notify\Factory\NotificationFactoryInterface')->getMock();

        $manager->addDriver(
            'notifier_1',
            function () use ($notifier) {
                return $notifier;
            }
        );

        $reflection = new \ReflectionClass(get_class($manager));
        $extensions = $reflection->getProperty('customCreators');
        $extensions->setAccessible(true);

        $this->assertCount(1, $extensions->getValue($manager));
        $this->assertCount(0, $manager->getDrivers());
    }

    public function test_make_notifier()
    {
        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $config
            ->method('get')
            ->with('drivers')
            ->willReturn(
                array(
                    'default_notifier' => array(
                        'scripts' => array('jquery.js', 'default_notifier.js'),
                        'styles' => array('default_notifier.css'),
                        'options' => array(),
                    ),
                    'another_notifier' => array(
                        'css_classes' => array(
                            'success' => 'success',
                        ),
                    ),
                )
            );

        $manager = new ProducerManager($config);

        $that = $this;

        $manager->addDriver(
            'default_notifier',
            function ($config) use ($that) {
                $that->assertEquals(
                    array(
                        'scripts' => array('jquery.js', 'default_notifier.js'),
                        'styles' => array('default_notifier.css'),
                        'options' => array(),
                        'driver' => 'default_notifier',
                    ),
                    $config
                );

                return $that->getMockBuilder('Yoeunes\Notify\Producer\ProducerInterface')->getMock();
            }
        );

        $defaultNotifier = $this->callMethod($manager, 'createDriver', 'default_notifier');

        $this->assertInstanceOf('Yoeunes\Notify\Producer\ProducerInterface', $defaultNotifier);
    }

    public function test_make_notifier_containing_notifier_option()
    {
        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $config
            ->method('get')
            ->with('drivers')
            ->willReturn(
                array(
                    'default_notifier' => array(
                        'scripts' => array('jquery.js', 'default_notifier.js'),
                        'styles' => array('default_notifier.css'),
                        'options' => array(),
                    ),
                    'another_notifier' => array(
                        'driver' => 'default_notifier',
                        'scripts' => array(),
                        'styles' => array(),
                        'options' => array(),
                    ),
                )
            );

        $manager = new ProducerManager($config);

        $that = $this;

        $manager->addDriver(
            'default_notifier',
            function ($config) use ($that) {
                $that->assertEquals(
                    array(
                        'scripts' => array(),
                        'styles' => array(),
                        'options' => array(),
                        'driver' => 'default_notifier',
                    ),
                    $config
                );

                return $that->getMockBuilder('Yoeunes\Notify\Producer\ProducerInterface')->getMock();
            }
        );

        $defaultNotifier = $this->callMethod($manager, 'createDriver', 'another_notifier');
        $this->assertInstanceOf('Yoeunes\Notify\Producer\ProducerInterface', $defaultNotifier);
    }
}
