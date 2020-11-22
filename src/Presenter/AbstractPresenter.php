<?php

namespace Notify\Presenter;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\LifeStamp;
use Notify\Envelope\Stamp\RendererStamp;
use Notify\Filter\FilterManager;
use Notify\Renderer\HasGlobalOptionsInterface;
use Notify\Renderer\HasScriptsInterface;
use Notify\Renderer\HasStylesInterface;
use Notify\Renderer\RendererManager;
use Notify\Storage\StorageInterface;

abstract class AbstractPresenter implements PresenterInterface
{
    /**
     * @var \Notify\Storage\StorageInterface
     */
    protected $storage;

    /**
     * @var \Notify\Filter\FilterManager
     */
    protected $filterManager;

    /**
     * @var \Notify\Renderer\RendererManager
     */
    protected $rendererManager;

    public function __construct(StorageInterface $storage, FilterManager $filterManager, RendererManager $rendererManager)
    {
        $this->storage = $storage;
        $this->filterManager = $filterManager;
        $this->rendererManager = $rendererManager;
    }

    protected function getEnvelopes($filterName, $criteria = [])
    {
        $filter = $this->filterManager->make($filterName);
        $envelopes = $filter->filter($this->storage->get(), $criteria);


        return array_filter($envelopes, function (Envelope $envelope) {
            $lifeStamp = $envelope->get('Notify\Envelope\Stamp\LifeStamp');

            return $lifeStamp->getLife() > 0;
        });
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    protected function getStyles($envelopes)
    {
        $files = [];
        $renderers = [];

        foreach ($envelopes as $envelope) {
            $rendererStamp = $envelope->get('Notify\Envelope\Stamp\RendererStamp');
            if (in_array($rendererStamp->getRenderer(), $renderers)) {
                continue;
            }

            $renderer = $this->rendererManager->make($rendererStamp->getRenderer());
            if (!$renderer instanceof HasStylesInterface) {
                continue;
            }

            $files = array_merge($files, $renderer->getStyles());
            $renderers[] = $rendererStamp->getRenderer();
        }

        return array_filter(array_unique($files));
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    protected function getScripts($envelopes)
    {
        $files = [];
        $renderers = [];

        foreach ($envelopes as $envelope) {
            $rendererStamp = $envelope->get('Notify\Envelope\Stamp\RendererStamp');
            if (in_array($rendererStamp->getRenderer(), $renderers)) {
                continue;
            }

            $renderer = $this->rendererManager->make($rendererStamp->getRenderer());
            if (!$renderer instanceof HasScriptsInterface) {
                continue;
            }

            $files = array_merge($files, $renderer->getScripts());
            $renderers[] = $rendererStamp->getRenderer();
        }

        return array_filter(array_unique($files));
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    protected function getOptions($envelopes)
    {
        $options = [];
        $renderers = [];

        foreach ($envelopes as $envelope) {
            $rendererStamp = $envelope->get('Notify\Envelope\Stamp\RendererStamp');
            if (in_array($rendererStamp->getRenderer(), $renderers)) {
                continue;
            }

            $renderer = $this->rendererManager->make($rendererStamp->getRenderer());
            if (!$renderer instanceof HasGlobalOptionsInterface) {
                continue;
            }

            $options[] = $renderer->renderOptions();
            $renderers[] = $rendererStamp->getRenderer();
        }

        return array_filter(array_unique($options));
    }

    /**
     * @inheritDoc
     */
    public function support(array $context)
    {
        return true;
    }
}
