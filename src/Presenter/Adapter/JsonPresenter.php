<?php

namespace Notify\Presenter\Adapter;

use Notify\Presenter\AbstractPresenter;

final class JsonPresenter extends AbstractPresenter
{
    /**
     * @param string|array $criteria
     *
     * @return array
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
            return array();
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
     * @return array
     */
    private function renderEnvelopes($envelopes)
    {
        $notifications = array();

        foreach ($envelopes as $envelope) {
            $rendererStamp = $envelope->get('Notify\Envelope\Stamp\HandlerStamp');
            $renderer      = $this->rendererManager->make($rendererStamp->getHandler());

            $notifications[] = array(
                'code'    => $renderer->render($envelope),
                'adapter' => $rendererStamp->getHandler()
            );
        }

        return $notifications;
    }
}
