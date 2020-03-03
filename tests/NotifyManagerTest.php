<?php

namespace Yoeunes\Notify\Tests;

use Yoeunes\Notify\NotifyManager;

final class NotifyManagerTest extends TestCase
{
    public function test_default_notifier()
    {
        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('default')
            ->willReturn('default_notifier');

        $manager = new NotifyManager($config);

        $this->assertEquals('default_notifier', $manager->getDefaultNotifier());
    }

    public function test_throw_exception_when_notifier_not_found()
    {
        $this->setExpectedException('InvalidArgumentException', 'Notifier [default_notifier] not configured');

        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();

        $manager = new NotifyManager($config);
        $manager->getNotifierConfig('default_notifier');
    }

    public function test_throw_exception_when_notifier_not_configured()
    {
        $this->setExpectedException('InvalidArgumentException', 'Notifier [default_notifier] not configured');

        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();

        $manager = new NotifyManager($config);
        $manager->getNotifierConfig('default_notifier');
    }

    public function test_get_notifier_config()
    {
        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $config
            ->expects($this->exactly(1))
            ->method('get')
            ->withConsecutive(array('notifiers'))
            ->willReturnOnConsecutiveCalls(
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

        $manager = new NotifyManager($config);
        $this->assertEquals(
            array(
                'scripts' => array('jquery.js', 'default_notifier.js'),
                'styles' => array('default_notifier.css'),
                'options' => array(),
                'notifier' => 'default_notifier',
            ),
            $manager->getNotifierConfig('default_notifier')
        );
    }

    public function test_make_unsupported_notifier()
    {
        $this->setExpectedException('InvalidArgumentException', 'Unsupported notifier [ default_notifier ]');

        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $config
            ->method('get')
            ->with('notifiers')
            ->willReturn(
                array(
                    'default_notifier' => array(
                        'scripts' => array('jquery.js', 'default_notifier.js'),
                        'styles' => array('default_notifier.css'),
                        'options' => array(),
                    ),
                )
            );

        $manager = new NotifyManager($config);
        $this->invokeMethod($manager, 'resolve', array('default_notifier'));
    }

    public function test_extend_to_add_more_notifiers_factory()
    {
        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $manager = new NotifyManager($config);

        $notifier = $this->getMockBuilder('Yoeunes\Notify\Factory\NotificationFactoryInterface')->getMock();

        $manager->extend(
            'notifier_1',
            function () use ($notifier) {
                return $notifier;
            }
        );

        $manager->extend('notifier_2', $this->getMockBuilder('Yoeunes\Notify\Factory\NotificationFactoryInterface'));

        $reflection = new \ReflectionClass(get_class($manager));
        $extensions = $reflection->getProperty('extensions');
        $extensions->setAccessible(true);

        $this->assertCount(2, $extensions->getValue($manager));
        $this->assertCount(0, $manager->getNotifiers());
    }

    public function test_make_notifier()
    {
        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $config
            ->method('get')
            ->with('notifiers')
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

        $manager = new NotifyManager($config);

        $that = $this;

        $manager->extend(
            'default_notifier',
            function ($config) use ($that) {
                $that->assertEquals(
                    array(
                        'scripts' => array('jquery.js', 'default_notifier.js'),
                        'styles' => array('default_notifier.css'),
                        'options' => array(),
                        'notifier' => 'default_notifier',
                    ),
                    $config
                );

                return $that->getMockBuilder('Yoeunes\Notify\Factory\NotificationFactoryInterface')->getMock();
            }
        );

        $manager->extend('another_notifier', $this->getMockBuilder('Yoeunes\Notify\Factory\NotificationFactoryInterface')->getMock());

        $defaultNotifier = $this->invokeMethod($manager, 'resolve', array('default_notifier'));
        $anotherNotifier = $this->invokeMethod($manager, 'resolve', array('another_notifier'));

        $this->assertInstanceOf('Yoeunes\Notify\Factory\NotificationFactoryInterface', $defaultNotifier);
        $this->assertInstanceOf('Yoeunes\Notify\Factory\NotificationFactoryInterface', $anotherNotifier);
    }

    public function test_make_notifier_containing_notifier_option()
    {
        $config = $this->getMockBuilder('Yoeunes\Notify\Config\ConfigInterface')->getMock();
        $config
            ->method('get')
            ->with('notifiers')
            ->willReturn(
                array(
                    'default_notifier' => array(
                        'scripts' => array('jquery.js', 'default_notifier.js'),
                        'styles' => array('default_notifier.css'),
                        'options' => array(),
                    ),
                    'another_notifier' => array(
                        'notifier' => 'default_notifier',
                        'scripts' => array(),
                        'styles' => array(),
                        'options' => array(),
                    ),
                )
            );

        $manager = new NotifyManager($config);

        $that = $this;

        $manager->extend(
            'default_notifier',
            function ($config) use ($that) {
                $that->assertEquals(
                    array(
                        'scripts' => array(),
                        'styles' => array(),
                        'options' => array(),
                        'notifier' => 'default_notifier',
                    ),
                    $config
                );

                return $that->getMockBuilder('Yoeunes\Notify\Factory\NotificationFactoryInterface')->getMock();
            }
        );

        $defaultNotifier = $this->invokeMethod($manager, 'resolve', array('another_notifier'));
        $this->assertInstanceOf('Yoeunes\Notify\Factory\NotificationFactoryInterface', $defaultNotifier);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on
     * @param string $methodName Method name to call
     * @param array  $parameters array of parameters to pass into method
     *
     * @return mixed method return
     *
     * @throws \ReflectionException
     */
    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
