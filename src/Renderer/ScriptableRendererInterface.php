<?php

namespace Yoeunes\Notify\Renderer;

interface ScriptableRendererInterface
{
    /**
     * @param array<string, \Yoeunes\Notify\Envelope\Envelope> $notifications
     *
     * @return string
     */
    public function renderScripts($notifications);
}
