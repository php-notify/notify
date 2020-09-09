<?php

namespace Yoeunes\Notify\Presenter;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Renderer\HasGlobalOptionsInterface;
use Yoeunes\Notify\Renderer\HasScriptsInterface;
use Yoeunes\Notify\Renderer\HasStylesInterface;
use Yoeunes\Notify\Renderer\RendererManager;
use Yoeunes\Notify\Storage\Filter\FilterManager;

final class HtmlPresenter extends AbstractPresenter
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

        $html = '';

        foreach ($this->drivers ?: [] as $driver) {
            $html .= $driver['options'] . PHP_EOL;

            foreach ($driver['envelopes'] as $envelope) {
                $html .= $envelope . PHP_EOL;
            }

            $html .= PHP_EOL;
        }

        return $html;
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
