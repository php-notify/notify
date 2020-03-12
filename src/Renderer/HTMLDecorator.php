<?php

namespace Yoeunes\Notify\Renderer;

final class HTMLDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render($notifiers)
    {
        $html = '';

        foreach ($notifiers as $notifier) {
            if ($notifier->readyToRender()) {
                $html .= $notifier->render().PHP_EOL;
            }
        }

        return trim($html);
    }

    /**
     * {@inheritdoc}
     */
    public function renderScripts($notifiers)
    {
        $html = '';

        foreach ($this->getScripts($notifiers) as $script) {
            $html .= sprintf('<script type="text/javascript" src="%s"></script>', $script).PHP_EOL;
        }

        return trim($html);
    }

    /**
     * {@inheritdoc}
     */
    public function renderStyles($notifiers)
    {
        $html = '';

        foreach ($this->getStyles($notifiers) as $style) {
            $html .= sprintf('<link rel="stylesheet" type="text/css" href="%s" />', $style).PHP_EOL;
        }

        return trim($html);
    }
}
