<?php

namespace Yoeunes\Notify\Presenter;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Renderer\HasGlobalOptionsInterface;
use Yoeunes\Notify\Renderer\HasScriptsInterface;
use Yoeunes\Notify\Renderer\HasStylesInterface;
use Yoeunes\Notify\Renderer\RendererManager;
use Yoeunes\Notify\Storage\Filter\FilterManager;

final class JsonPresenter extends AbstractPresenter
{
    private $renderer;

    private $drivers;

    public function __construct(FilterManager $filter, RendererManager $renderer)
    {
        parent::__construct($filter);

        $this->renderer = $renderer;
    }

    /**
     * @inheritDoc
     */
    public function support(array $context)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->initRenderingProcess();

        return json_encode(array(
            'scripts' => $this->getResultsByColumn('scripts'),
            'styles' => $this->getResultsByColumn('styles'),
            'options' => array_values(array_filter(array_column($this->drivers ?: [], 'options'))),
            'notifications' => $this->getResultsByColumn('envelopes')
        ));
    }

    private function getResultsByColumn($column)
    {
        $results = array_column($this->drivers ?: [], $column);

        $results = array_reduce($results, 'array_merge', array());

        $results = array_filter($results);

        return array_values(array_unique($results));
    }

    private function initRenderingProcess()
    {
        if (null !== $this->drivers) {
            return;
        }

        foreach ($this->getEnvelopes() as $envelope) {
            $this->addEnvelope($envelope);
        }
    }

    private function addEnvelope(Envelope $envelope)
    {
        $stamp = $envelope->get('Yoeunes\Notify\Envelope\Stamp\RendererStamp');

        if (null === $stamp) {
            return;
        }

        $name = $stamp->getRenderer();

        if (!isset($this->drivers[$name])) {
            $this->drivers[$name] = $this->createEmptyPresenter($name);
        }

        $this->drivers[$name]['envelopes'][] = $this->drivers[$name]['renderer']->render($envelope);
    }

    /**
     * @param string $name
     *
     * @return array
     */
    private function createEmptyPresenter($name)
    {
        $renderer = $this->renderer->make($name);

        $driver = array(
            'renderer' => $renderer,
            'scripts' => array(),
            'styles' => array(),
            'options' => array(),
            'envelopes' => array(),
        );

        if ($renderer instanceof HasScriptsInterface) {
            $driver['scripts'] = $renderer->getScripts();
        }

        if ($renderer instanceof HasStylesInterface) {
            $driver['styles'] = $renderer->getStyles();
        }

        if ($renderer instanceof HasGlobalOptionsInterface) {
            $driver['options'] = $renderer->renderOptions();
        }

        return $driver;
    }
}
