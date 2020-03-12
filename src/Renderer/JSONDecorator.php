<?php

namespace Yoeunes\Notify\Renderer;

final class JSONDecorator
{
    /**
     * {@inheritdoc}
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

        return json_encode(
            array(
                'notifications' => $notifications,
                'scripts' => $this->getScripts($notifiers),
                'styles' => $this->getStyles($notifiers),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function renderScripts($notifiers)
    {
        return json_encode(array('scripts' => $this->getScripts($notifiers)));
    }

    /**
     * {@inheritdoc}
     */
    public function renderStyles($notifiers)
    {
        return json_encode(array('styles' => $this->getStyles($notifiers)));
    }
}
