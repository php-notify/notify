<?php

namespace Notify\Presenter\Adapter;

use Notify\Presenter\AbstractPresenter;

final class JsonPresenter extends AbstractPresenter
{
    /**
     * @param string|array $criteria
     *
     * @return string
     */
    public function render($criteria = null)
    {
        $filterName = 'default';

        if (is_string($criteria)) {
            $filterName = $criteria;
            $criteria   = array();
        }

        $envelopes = $this->getEnvelopes($filterName, $criteria);

        if (empty($envelopes)) {
            return '';
        }

        $response = array(
            'scripts'       => $this->getScripts($envelopes),
            'styles'        => $this->getStyles($envelopes),
            'options'       => $this->getOptions($envelopes),
            'notifications' => $this->renderEnvelopes($envelopes),
        );

        $this->storage->flush($envelopes);

        return $response;
    }

    /**
     * @param \Notify\Envelope\Envelope[] $envelopes
     *
     * @return string
     */
    private function renderEnvelopes($envelopes)
    {
        $notifications = array();

        foreach ($envelopes as $envelope) {
            $rendererStamp = $envelope->get('Notify\Envelope\Stamp\RendererStamp');
            $renderer      = $this->rendererManager->make($rendererStamp->getRenderer());

            $notifications[] = array(
                'code'    => $renderer->render($envelope),
                'adapter' => $rendererStamp->getRenderer()
            );
        }

        return $notifications;
    }
}
