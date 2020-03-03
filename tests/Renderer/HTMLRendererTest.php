<?php

namespace Yoeunes\Notify\Tests\Renderer;

use Yoeunes\Notify\Renderer\HTMLRenderer;
use Yoeunes\Notify\Tests\TestCase;

final class HTMLRendererTest extends TestCase
{
    public function test_render_with_empty_array()
    {
        $renderer = new HTMLRenderer();

        $this->assertEquals('', $renderer->render(array()));
    }

    public function test_render_with_one_notifier_and_the_notifier_is_not_ready_to_render()
    {
        $notifier = $this->getMockBuilder('Yoeunes\Notify\Factory\NotificationFactoryInterface')->getMock();
        $notifier
            ->expects($this->once())
            ->method('readyToRender')
            ->willReturn(false);
        $notifier
            ->expects($this->never())
            ->method('render');

        $renderer = new HTMLRenderer();

        $this->assertEquals('', $renderer->render(array($notifier)));
    }

    public function test_render_with_one_notifier_ready_to_render()
    {
        $notifier = $this->getMockBuilder('Yoeunes\Notify\Factory\NotificationFactoryInterface')->getMock();
        $notifier
            ->expects($this->once())
            ->method('readyToRender')
            ->willReturn(true);
        $notifier
            ->expects($this->once())
            ->method('render')
            ->willReturn("notifier.success('happy message');");

        $renderer = new HTMLRenderer();

        $this->assertEquals("notifier.success('happy message');", $renderer->render(array($notifier)));
    }

    public function test_render_with_two_notifiers_ready_to_render()
    {
        $notifier = $this->getMockBuilder('Yoeunes\Notify\Factory\NotificationFactoryInterface')->getMock();
        $notifier
            ->expects($this->once())
            ->method('readyToRender')
            ->willReturn(true);
        $notifier
            ->expects($this->once())
            ->method('render')
            ->willReturn("notifier.success('happy message');");

        $anotherNotifier = $this->getMockBuilder('Yoeunes\Notify\Factory\NotificationFactoryInterface')->getMock();
        $anotherNotifier
            ->expects($this->once())
            ->method('readyToRender')
            ->willReturn(true);
        $anotherNotifier
            ->expects($this->once())
            ->method('render')
            ->willReturn("notifier.info('info message');");

        $renderer = new HTMLRenderer();

        $this->assertEquals("notifier.success('happy message');\nnotifier.info('info message');", $renderer->render(array($notifier, $anotherNotifier)));
    }

    public function test_render_scripts_with_empty_array()
    {
        $renderer = new HTMLRenderer();

        $this->assertEquals('', $renderer->renderScripts(array()));
    }

    public function test_render_scripts_with_one_notifier_and_the_notifier_is_not_instance_of_scriptable()
    {
        $notifier = $this->getMockBuilder('Yoeunes\Notify\Factory\NotificationFactoryInterface')->getMock();
        $notifier
            ->expects($this->never())
            ->method('readyToRender');
        $notifier
            ->expects($this->never())
            ->method('render');

        $renderer = new HTMLRenderer();

        $this->assertEquals('', $renderer->renderScripts(array($notifier)));
    }

    public function test_render_scripts_with_one_notifier_and_the_notifier_is_not_ready_to_render()
    {
        $notifier = $this->prophesize('Yoeunes\Notify\Factory\NotificationFactoryInterface');
        $notifier->willImplement('Yoeunes\Notify\Factory\Behaviour\ScriptableInterface');

        $notifier
            ->readyToRender()
            ->shouldBeCalled()
            ->willReturn(false);

        $notifier
            ->getScripts()
            ->shouldNotBeCalled();

        $renderer = new HTMLRenderer();

        $this->assertEquals('', $renderer->renderScripts(array($notifier->reveal())));
    }

    public function test_render_scripts_with_one_notifier_ready_to_render()
    {
        $notifier = $this->prophesize('Yoeunes\Notify\Factory\NotificationFactoryInterface');
        $notifier->willImplement('Yoeunes\Notify\Factory\Behaviour\ScriptableInterface');

        $notifier
            ->readyToRender()
            ->shouldBeCalled()
            ->willReturn(true);

        $notifier
            ->getScripts()
            ->shouldBeCalled()
            ->willReturn(array('jquery.js', 'script.js'));

        $renderer = new HTMLRenderer();

        $this->assertEquals('<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="script.js"></script>', $renderer->renderScripts(array($notifier->reveal())));
    }

    public function test_render_scripts_with_two_notifiers_ready_to_render()
    {
        $notifier = $this->prophesize('Yoeunes\Notify\Factory\NotificationFactoryInterface');
        $notifier->willImplement('Yoeunes\Notify\Factory\Behaviour\ScriptableInterface');
        $notifier
            ->readyToRender()
            ->shouldBeCalled()
            ->willReturn(true);
        $notifier
            ->getScripts()
            ->shouldBeCalled()
            ->willReturn(array('jquery.js', 'notifier.js'));

        $anotherNotifier = $this->prophesize('Yoeunes\Notify\Factory\NotificationFactoryInterface');
        $anotherNotifier->willImplement('Yoeunes\Notify\Factory\Behaviour\ScriptableInterface');
        $anotherNotifier
            ->readyToRender()
            ->shouldBeCalled()
            ->willReturn(true);
        $anotherNotifier
            ->getScripts()
            ->shouldBeCalled()
            ->willReturn(array('jquery.js', 'anotherNotifier.js'));

        $renderer = new HTMLRenderer();

        $scripts = $renderer->renderScripts(array($notifier->reveal(), $anotherNotifier->reveal()));
        $expected = '<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="notifier.js"></script>
<script type="text/javascript" src="anotherNotifier.js"></script>';

        $this->assertEquals($expected, $scripts);
    }

    public function test_render_styles_with_empty_array()
    {
        $renderer = new HTMLRenderer();

        $this->assertEquals('', $renderer->renderStyles(array()));
    }

    public function test_render_styles_with_one_notifier_and_the_notifier_is_not_instance_of_scriptable()
    {
        $notifier = $this->getMockBuilder('Yoeunes\Notify\Factory\NotificationFactoryInterface')->getMock();
        $notifier
            ->expects($this->never())
            ->method('readyToRender');
        $notifier
            ->expects($this->never())
            ->method('render');

        $renderer = new HTMLRenderer();

        $this->assertEquals('', $renderer->renderStyles(array($notifier)));
    }

    public function test_render_styles_with_one_notifier_and_the_notifier_is_not_ready_to_render()
    {
        $notifier = $this->prophesize('Yoeunes\Notify\Factory\NotificationFactoryInterface');
        $notifier->willImplement('Yoeunes\Notify\Factory\Behaviour\StyleableInterface');

        $notifier
            ->readyToRender()
            ->shouldBeCalled()
            ->willReturn(false);

        $notifier
            ->getStyles()
            ->shouldNotBeCalled();

        $renderer = new HTMLRenderer();

        $this->assertEquals('', $renderer->renderStyles(array($notifier->reveal())));
    }

    public function test_render_styles_with_one_notifier_ready_to_render()
    {
        $notifier = $this->prophesize('Yoeunes\Notify\Factory\NotificationFactoryInterface');
        $notifier->willImplement('Yoeunes\Notify\Factory\Behaviour\StyleableInterface');

        $notifier
            ->readyToRender()
            ->shouldBeCalled()
            ->willReturn(true);

        $notifier
            ->getStyles()
            ->shouldBeCalled()
            ->willReturn(array('bootstrap.css', 'style.css'));

        $renderer = new HTMLRenderer();

        $this->assertEquals('<link rel="stylesheet" type="text/css" href="bootstrap.css" />
<link rel="stylesheet" type="text/css" href="style.css" />', $renderer->renderStyles(array($notifier->reveal())));
    }

    public function test_render_styles_with_two_notifiers_ready_to_render()
    {
        $notifier = $this->prophesize('Yoeunes\Notify\Factory\NotificationFactoryInterface');
        $notifier->willImplement('Yoeunes\Notify\Factory\Behaviour\StyleableInterface');
        $notifier
            ->readyToRender()
            ->shouldBeCalled()
            ->willReturn(true);
        $notifier
            ->getStyles()
            ->shouldBeCalled()
            ->willReturn(array('bootstrap.css', 'notifier.css'));

        $anotherNotifier = $this->prophesize('Yoeunes\Notify\Factory\NotificationFactoryInterface');
        $anotherNotifier->willImplement('Yoeunes\Notify\Factory\Behaviour\StyleableInterface');
        $anotherNotifier
            ->readyToRender()
            ->shouldBeCalled()
            ->willReturn(true);
        $anotherNotifier
            ->getStyles()
            ->shouldBeCalled()
            ->willReturn(array('bootstrap.css', 'anotherNotifier.js'));

        $renderer = new HTMLRenderer();

        $styles = $renderer->renderStyles(array($notifier->reveal(), $anotherNotifier->reveal()));
        $expected = '<link rel="stylesheet" type="text/css" href="bootstrap.css" />
<link rel="stylesheet" type="text/css" href="notifier.css" />
<link rel="stylesheet" type="text/css" href="anotherNotifier.js" />';

        $this->assertEquals($expected, $styles);
    }
}
