<?php

namespace Notify\Presenter\Adapter;

use Notify\Presenter\AbstractPresenter;

final class HtmlPresenter extends AbstractPresenter
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
            $criteria = array();
        }

        $envelopes = $this->getEnvelopes($filterName, $criteria);

        if (empty($envelopes)) {
            return '';
        }

        $scripts = $this->renderScripts($envelopes);
        $styles = json_encode($this->getStyles($envelopes));
        $options = $this->renderOptions($envelopes);
        $notifications = $this->renderEnvelopes($envelopes);

        $html = <<<HTML
{$scripts}
<script type="text/javascript">
var renderPHPNotifyNotifications = function () {
    {$options}
    {$notifications}
}

if ("undefined" !== typeof PHPNotify) {
    PHPNotify.addStyles({$styles}, renderPHPNotifyNotifications);
} else {
    renderPHPNotifyNotifications();
}
</script>
HTML;

        $this->storage->flush($envelopes);

        return $html;
    }

    /**
     * @param \Notify\Envelope\Envelope[] $envelopes
     *
     * @return string
     */
    public function renderEnvelopes($envelopes)
    {
        $html = '';

        foreach ($envelopes as $envelope) {
            $rendererStamp = $envelope->get('Notify\Envelope\Stamp\RendererStamp');
            $renderer = $this->rendererManager->make($rendererStamp->getRenderer());

            $html .= $renderer->render($envelope) . PHP_EOL;
        }

        return $html;
    }

    /**
     * @param \Notify\Envelope\Envelope[] $envelopes
     *
     * @return string
     */
    public function renderOptions($envelopes)
    {
        $html = '';

        foreach ($this->getOptions($envelopes) as $option) {
            $html .= $option . PHP_EOL;
        }

        return $html;
    }

    /**
     * @return string
     */
    public function renderScripts($envelopes)
    {
        $html = '';

        foreach ($this->getScripts($envelopes) as $file) {
            $html .= sprintf('<script src="%s"></script>', $file) . PHP_EOL;
        }

        return $html;
    }
}
