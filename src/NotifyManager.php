<?php

namespace Yoeunes\Notify;

use Yoeunes\Notify\Config\ConfigInterface;
use Yoeunes\Notify\Factories\NotifierFactoryInterface;
use Yoeunes\Notify\Renderer\HTMLRenderer;

class NotifyManager
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
     * @var array<string,object>
     */
    protected $notifiers = array();

    /**
     * The custom notifiers resolvers.
     *
     * @var array<string,callable>
     */
    protected $extensions = array();

    /** @var \Yoeunes\Notify\Renderer\RendererInterface */
    protected $renderer;

    /**
     * Create a new manager instance.
     *
     * @param \Yoeunes\Notify\Config\ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->renderer = new HTMLRenderer();
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
            $this->notifiers[$name] = $this->makeNotifier($name);
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
    protected function makeNotifier($name)
    {
        $config = $this->getNotifierConfig($name);

        if (isset($this->extensions[$name])) {
            return $this->extensions[$name]($config);
        }

        if (isset($config['notifier']) && isset($this->extensions[$config['notifier']])) {
            return $this->extensions[$config['notifier']]($config);
        }

        throw new \InvalidArgumentException("Unsupported notifier [ {$name} ].");
    }

    /**
     * Get the configuration for a notifier.
     *
     * @param string|null $name
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getNotifierConfig($name = null)
    {
        $name = $name ?: $this->getDefaultNotifier();

        $notifiers = $this->config->get('notifiers');

        if (!isset($notifiers[$name]) || !is_array($notifiers[$name])) {
            throw new \InvalidArgumentException("Notifier [$name] not configured.");
        }

        $config = $notifiers[$name];

        $config += [
            'name' => $name,
            'exception' => $this->config->get('exception'),
            'session_key' => $this->config->get('session_key'),
        ];

        return $config;
    }

    public function render()
    {
        return $this->renderer->render($this->getNotifiers());
    }

    public function renderScripts()
    {
        return $this->renderer->renderScripts($this->getNotifiers());
    }

    public function renderStyles()
    {
        return $this->renderer->renderStyles($this->getNotifiers());
    }

    /**
     * Register an extension notifier resolver.
     *
     * @param string   $name
     * @param callable $resolver
     *
     * @return void
     */
    public function extend($name, $resolver)
    {
        if ($resolver instanceof \Closure) {
            $this->extensions[$name] = $resolver->bindTo($this, $this);
        } else {
            $this->extensions[$name] = $resolver;
        }
    }

    /**
     * @return array<string, NotifierFactoryInterface>
     */
    public function getNotifiers()
    {
        return $this->notifiers;
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
}
