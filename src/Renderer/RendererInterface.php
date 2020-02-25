<?php

namespace Yoeunes\Notify\Renderer;

interface RendererInterface
{
    public function render($notifiers);

    public function renderScripts($notifiers);

    public function renderStyles($notifiers);
}
