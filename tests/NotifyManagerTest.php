<?php

namespace Yoeunes\Notify\Tests;

use Yoeunes\Notify\NotifyManager;

class NotifyManagerTest extends \PHPUnit\Framework\TestCase
{
    public function test_default_notifier()
    {
        $config = $this->getMock('Yoeunes\Notify\Config\ConfigInterface');
        $config->method('get')
            ->with('default')
            ->willReturn('default_notifier');

        $manager = new NotifyManager($config);

        $this->assertEquals('default_notifier', $manager->getDefaultNotifier());
    }

    public function test_throw_exception_when_notifier_not_found()
    {
        $this->setExpectedException('InvalidArgumentException', 'Notifier [default_notifier] not configured');

        $config = $this->getMock('Yoeunes\Notify\Config\ConfigInterface');

        $manager = new NotifyManager($config);
        $manager->getNotifierConfig('default_notifier');
    }

    public function test_throw_exception_when_notifier_not_configured()
    {
        $this->setExpectedException('InvalidArgumentException', 'Notifier [default_notifier] not configured');

        $config = $this->getMock('Yoeunes\Notify\Config\ConfigInterface');

        $manager = new NotifyManager($config);
        $manager->getNotifierConfig('default_notifier');
    }

    public function test_get_notifier_config()
    {
        $config = $this->getMock('Yoeunes\Notify\Config\ConfigInterface');
        $config
            ->expects($this->exactly(2))
            ->method('get')
            ->withConsecutive(array('default'), array('notifiers'))
            ->willReturnOnConsecutiveCalls(
                'default_notifier',
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
                'name' => 'default_notifier',
            ),
            $manager->getNotifierConfig()
        );
    }

    public function test_make_unsupported_notifier()
    {
        $this->setExpectedException('InvalidArgumentException', 'Unsupported notifier [ default_notifier ]');

        $config = $this->getMock('Yoeunes\Notify\Config\ConfigInterface');
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
        $this->invokeMethod($manager, 'makeNotifier', array('default_notifier'));
    }

    public function test_extend_to_add_more_notifiers_factory()
    {
        $config = $this->getMock('Yoeunes\Notify\Config\ConfigInterface');
        $manager = new NotifyManager($config);

        $notifier = $this->getMock('Yoeunes\Notify\Factories\NotifierFactoryInterface');

        $manager->extend(
            'notifier_1',
            function () use ($notifier) {
                return $notifier;
            }
        );

        $manager->extend('notifier_2', $this->getMock('Yoeunes\Notify\Factories\NotifierFactoryInterface'));

        $reflection = new \ReflectionClass(get_class($manager));
        $extensions = $reflection->getProperty('extensions');
        $extensions->setAccessible(true);

        $this->assertCount(2, $extensions->getValue($manager));
        $this->assertCount(0, $manager->getNotifiers());
    }

    public function test_make_notifier()
    {
        $config = $this->getMock('Yoeunes\Notify\Config\ConfigInterface');
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
                        'name' => 'default_notifier',
                    ),
                    $config
                );

                return $that->getMock('Yoeunes\Notify\Factories\NotifierFactoryInterface');
            }
        );

        $manager->extend('another_notifier', $this->getMock('Yoeunes\Notify\Factories\NotifierFactoryInterface'));

        $defaultNotifier = $this->invokeMethod($manager, 'makeNotifier', array('default_notifier'));
        $anotherNotifier = $this->invokeMethod($manager, 'makeNotifier', array('another_notifier'));

        $this->assertInstanceOf('Yoeunes\Notify\Factories\NotifierFactoryInterface', $defaultNotifier);
        $this->assertInstanceOf('Yoeunes\Notify\Factories\NotifierFactoryInterface', $anotherNotifier);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object     Instantiated object that we will run method on.
     * @param string  $methodName Method name to call
     * @param array   $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
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
