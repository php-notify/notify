<?php

namespace Notify\Renderer;

use Notify\Envelope\Envelope;

interface RendererInterface
{
    /**
     * @param \Notify\Envelope\Envelope $envelope
     *
     * @return string
     */
    public function render(Envelope $envelope);
}
