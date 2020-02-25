<?php

namespace Yoeunes\Notify\Renderer;

class HTMLRenderer extends BaseRenderer
{
    public function render($notifiers)
    {
        $html = '';

        foreach ($notifiers as $notifier) {
            if ($notifier->readyToRender()) {
                $html .= $notifier->render() .  str_repeat(PHP_EOL, 2);
            }
        }

        return $html;
    }

    public function renderScripts($notifiers)
    {
        $html = '';

        foreach ($this->getScripts($notifiers) as $script) {
            $html .= sprintf('<script type="text/javascript" src="%s"></script>', $script) . PHP_EOL;
        }

        return $html;
    }

    public function renderStyles($notifiers)
    {
        $html = '';

        foreach ($this->getStyles($notifiers) as $style) {
            $html .= sprintf('<link rel="stylesheet" type="text/css" href="%s" />', $style) . PHP_EOL;
        }

        return $html;
    }
}
