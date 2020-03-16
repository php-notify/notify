<?php

namespace Yoeunes\Notify\Envelope\Stamp;

final class RendererStamp implements StampInterface
{
    /**
     * @var string
     */
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @return string
     */
    public function getRenderer()
    {
        return $this->renderer;
    }
}
