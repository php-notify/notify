<?php

namespace Yoeunes\Notify\Renderer;

final class JSONRenderer extends AbstractRenderer
{
    /**
     * @inheritDoc
     */
    public function render($notifiers)
    {
        $notifications = array();

        /** @var \Yoeunes\Notify\Factory\NotificationFactoryInterface $notifier */
        foreach ($notifiers as $notifier) {
            if ($notifier->readyToRender()) {
                $notifications[] = $notifier->render();
            }
        }

        return json_encode(array(
            'notifications' => $notifications,
            'scripts' => $this->getScripts($notifiers),
            'styles' => $this->getStyles($notifiers)
        ));
    }

    /**
     * @inheritDoc
     */
    public function renderScripts($notifiers)
    {
        return json_encode(array('scripts' => $this->getScripts($notifiers)));
    }

    /**
     * @inheritDoc
     */
    public function renderStyles($notifiers)
    {
        return json_encode(array('styles' => $this->getStyles($notifiers)));
    }
}
