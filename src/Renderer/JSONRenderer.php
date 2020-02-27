<?php

namespace Yoeunes\Notify\Renderer;

final class JSONRenderer extends BaseRenderer
{
    public function render($notifiers)
    {
        $notifications = array();

        /** @var \Yoeunes\Notify\Factories\NotifierFactoryInterface $notifier */
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

    public function renderScripts($notifiers)
    {
        return json_encode(array('scripts' => $this->getScripts($notifiers)));
    }

    public function renderStyles($notifiers)
    {
        return json_encode(array('styles' => $this->getStyles($notifiers)));
    }
}
