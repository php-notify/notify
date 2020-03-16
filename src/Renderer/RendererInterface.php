<?php

namespace Yoeunes\Notify\Renderer;

use Yoeunes\Notify\Envelope\Envelope;

interface RendererInterface
{
    /**
     * @param \Yoeunes\Notify\Envelope\Envelope $envelope
     *
     * @return string
     */
    public function render(Envelope $envelope);
}
