<?php

namespace Yoeunes\Notify\Renderer;

interface StyleableRendererInterface
{
    /**
     * @param array<string, \Yoeunes\Notify\Envelope\Envelope> $notifications
     *
     * @return string
     */
    public function renderStyles($notifications);
}
