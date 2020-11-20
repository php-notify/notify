<?php

namespace Notify\Presenter;

use Notify\Renderer\RendererManager;
use Notify\Storage\StorageInterface;

abstract class AbstractPresenter implements PresenterInterface
{
    /**
     * @var \Notify\Storage\StorageInterface
     */
    protected $storage;

    /**
     * @var \Notify\Renderer\RendererManager
     */
    protected $rendererManager;

    public function __construct(StorageInterface $storage, RendererManager $rendererManager)
    {
        $this->storage = $storage;
        $this->rendererManager = $rendererManager;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $html = '';

        foreach ($this->storage->get() as $envelope) {
            $renderer = $this->rendererManager->make($envelope->get('Notify\Envelope\Stamp\RendererStamp'));
            $html .= $renderer->render($envelope) . PHP_EOL;
        }

        return $html;
    }

    /**
     * @inheritDoc
     */
    public function support(array $context)
    {
        return true;
    }
}
