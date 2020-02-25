<?php

namespace Yoeunes\Notify\Renderer;

use Yoeunes\Notify\Factories\Behaviours\ScriptableInterface;
use Yoeunes\Notify\Factories\Behaviours\StyleableInterface;

abstract class BaseRenderer implements RendererInterface
{
    public function getScripts($notifiers)
    {
        $scripts = [];

        foreach ($notifiers as $notifier) {
            if ($notifier instanceof ScriptableInterface && $notifier->readyToRender()) {
                $scripts = array_merge($scripts, $notifier->getScripts());
            }
        }

        return array_values(array_unique($scripts));
    }

    public function getStyles($notifiers)
    {
        $styles = [];

        foreach ($notifiers as $notifier) {
            if ($notifier instanceof StyleableInterface && $notifier->readyToRender()) {
                $styles = array_merge($styles, $notifier->getStyles());
            }
        }

        return array_values(array_unique($styles));
    }
}
