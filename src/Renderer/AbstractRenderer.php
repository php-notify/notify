<?php

namespace Yoeunes\Notify\Renderer;

use Yoeunes\Notify\Factories\Behaviours\ScriptableInterface;
use Yoeunes\Notify\Factories\Behaviours\StyleableInterface;
use Yoeunes\Notify\Factories\NotificationFactoryInterface;

abstract class AbstractRenderer implements RendererInterface
{
    /**
     * @param array<string, NotificationFactoryInterface> $notifiers
     *
     * @return array<int, string>
     */
    protected function getScripts($notifiers)
    {
        $scripts = array();

        foreach ($notifiers as $notifier) {
            if ($notifier instanceof ScriptableInterface && $notifier->readyToRender()) {
                $scripts = array_merge($scripts, $notifier->getScripts());
            }
        }

        return array_values(array_unique($scripts));
    }

    /**
     * @param array<string, NotificationFactoryInterface> $notifiers
     *
     * @return array<int, string>
     */
    protected function getStyles($notifiers)
    {
        $styles = array();

        foreach ($notifiers as $notifier) {
            if ($notifier instanceof StyleableInterface && $notifier->readyToRender()) {
                $styles = array_merge($styles, $notifier->getStyles());
            }
        }

        return array_values(array_unique($styles));
    }
}
