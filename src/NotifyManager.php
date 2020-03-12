<?php

namespace Yoeunes\Notify;

use Yoeunes\Notify\Config\ConfigInterface;
use Yoeunes\Notify\Factory\NotificationFactoryInterface;
use Yoeunes\Notify\Middleware\MiddlewareStack;
use Yoeunes\Notify\Renderer\HTMLRenderer;
use Yoeunes\Notify\Renderer\RendererInterface;

/**
 * @method \Yoeunes\Notify\Notification\NotificationInterface notification(string $type, string $message, string $title = '', array $context = array())
 * @method \Yoeunes\Notify\Notification\NotificationInterface success(string $message, string $title = '', array $context = array())
 * @method \Yoeunes\Notify\Notification\NotificationInterface info(string $message, string $title = '', array $context = array())
 * @method \Yoeunes\Notify\Notification\NotificationInterface warning(string $message, string $title = '', array $context = array())
 * @method \Yoeunes\Notify\Notification\NotificationInterface error(string $message, string $title = '', array $context = array())
 * @method bool readyToRender()
 * @method void setConfig(array $config)
 */
final class NotifyManager implements NotifyManagerInterface
{
    /**
     * The config instance.
     *
     * @var \Yoeunes\Notify\Config\ConfigInterface
     */
    private $config;

    /**
     * The active notifiers instances.
     *
     * @var array<string, NotificationFactoryInterface>
     */
    private $notifiers = array();

    /**
     * The custom notifiers resolvers.
     *
     * @var array<string, callable>
     */
    private $extensions = array();

    /**
     * @var \Yoeunes\Notify\Renderer\RendererInterface
     */
    private $renderer;

    /**
     * @var \Yoeunes\Notify\Middleware\MiddlewareStack
     */
    private $middleware;

    /**
     * Create a new manager instance.
     *
     * @param \Yoeunes\Notify\Config\ConfigInterface     $config
     * @param \Yoeunes\Notify\Middleware\MiddlewareStack $middleware
     */
    public function __construct(ConfigInterface $config, MiddlewareStack $middleware)
    {
        $this->config = $config;
        $this->renderer = new HTMLRenderer();
        $this->middleware = $middleware;
    }

    /**
     * Dynamically pass methods to the default notifier.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        return call_user_func_array(array($this->notifier(), $method), $parameters);
    }

    /**
     * Get a notifier instance.
     *
     * @param string|null $name
     *
     * @return object
     */
    public function notifier($name = null)
    {
        $name = $name ?: $this->getDefaultNotifier();

        if (!isset($this->notifiers[$name])) {
            $this->notifiers[$name] = $this->resolve($name);
        }

        return $this->notifiers[$name];
    }

    /**
     * Get the default notifier name.
     *
     * @return string
     */
    public function getDefaultNotifier()
    {
        return $this->config->get('default');
    }

    /**
     * Make the notifier instance.
     *
     * @param string $name
     *
     * @return object
     */
    private function resolve($name)
    {
        $config = $this->getNotifierConfig($name);

        $notifier = $config['notifier'];

        if (!isset($this->extensions[$notifier])) {
            throw new \InvalidArgumentException(sprintf('Unsupported notifier [ %s ]', $notifier));
        }

        return $this->extensions[$notifier]($config);
    }

    /**
     * Get the configuration for a notifier.
     *
     * @param string $name
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    public function getNotifierConfig($name)
    {
        $notifiers = $this->config->get('notifiers');

        if (!isset($notifiers[$name]) || !is_array($notifiers[$name])) {
            throw new \InvalidArgumentException(sprintf('Notifier [%s] not configured', $name));
        }

        $config = $notifiers[$name];

        return $config + array(
                'notifier' => $name,
//            'exception' => $this->config->get('exception'),
//            'session_key' => $this->config->get('session_key')
            );
    }

    /**
     * @param \Yoeunes\Notify\Renderer\RendererInterface $renderer
     *
     * @return \Yoeunes\Notify\NotifyManager
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->renderer->render($this->getNotifiers());
    }

    /**
     * Get active notifiers instances.
     *
     * @return array<string, NotificationFactoryInterface>
     */
    public function getNotifiers()
    {
        return $this->notifiers;
    }

    /**
     * @return string
     */
    public function renderScripts()
    {
        return $this->renderer->renderScripts($this->getNotifiers());
    }

    /**
     * @return string
     */
    public function renderStyles()
    {
        return $this->renderer->renderStyles($this->getNotifiers());
    }

    /**
     * Register an extension notifier resolver.
     *
     * @param string                                $name
     * @param \Closure|NotificationFactoryInterface $resolver
     */
    public function extend($name, $resolver)
    {
        if ($resolver instanceof NotificationFactoryInterface) {
            $resolver = function ($config) use ($resolver) {
                $resolver->setConfig($config);

                return $resolver;
            };
        }

        $this->extensions[$name] = $resolver;
    }
}
