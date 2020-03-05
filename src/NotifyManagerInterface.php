<?php

namespace Yoeunes\Notify;

use Yoeunes\Notify\Factory\NotificationFactoryInterface;
use Yoeunes\Notify\Renderer\RendererInterface;

interface NotifyManagerInterface
{
    /**
     * Get a notifier instance.
     *
     * @param string|null $name
     *
     * @return object
     */
    public function notifier($name = null);

    /**
     * Get the default notifier name.
     *
     * @return string
     */
    public function getDefaultNotifier();

    /**
     * Get the configuration for a notifier.
     *
     * @param string $name
     *
     * @return array
     * @throws \InvalidArgumentException
     *
     */
    public function getNotifierConfig($name);

    /**
     * @param \Yoeunes\Notify\Renderer\RendererInterface $renderer
     *
     * @return \Yoeunes\Notify\NotifyManager
     */
    public function setRenderer(RendererInterface $renderer);

    /**
     * @return string
     */
    public function render();

    /**
     * @return string
     */
    public function renderScripts();

    /**
     * @return string
     */
    public function renderStyles();

    /**
     * Register an extension notifier resolver.
     *
     * @param string $name
     * @param \Closure|NotificationFactoryInterface $resolver
     */
    public function extend($name, $resolver);

    /**
     * Get active notifiers instances.
     *
     * @return array<string, NotificationFactoryInterface>
     */
    public function getNotifiers();
}
