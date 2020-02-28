<?php

namespace Yoeunes\Notify\Renderer;

use Yoeunes\Notify\Factory\NotificationFactoryInterface;

interface RendererInterface
{
    /**
     * @param array<string, NotificationFactoryInterface> $notifiers
     *
     * @return string
     */
    public function render($notifiers);

    /**
     * @param array<string, NotificationFactoryInterface> $notifiers
     *
     * @return string
     */
    public function renderScripts($notifiers);

    /**
     * @param array<string, NotificationFactoryInterface> $notifiers
     *
     * @return string
     */
    public function renderStyles($notifiers);
}
