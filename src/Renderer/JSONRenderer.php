<?php

namespace Yoeunes\Notify\Renderer;

class JSONRenderer extends BaseRenderer
{
    public function render($notifiers)
    {
        $notifications = [];

        /** @var \Yoeunes\Notify\Factories\NotifierFactoryInterface $notifier */
        foreach ($notifiers as $notifier) {
            if ($notifier->readyToRender()) {
                $notifications[] = $notifier->render();
            }
        }

        return json_encode([
            'notifications' => $notifications,
            'scripts' => $this->getScripts($notifiers),
            'styles' => $this->getStyles($notifiers),
        ]);
    }

    public function renderScripts($notifiers)
    {
        return json_encode(['scripts' => $this->getScripts($notifiers)]);
    }

    public function renderStyles($notifiers)
    {
        return json_encode(['styles' => $this->getStyles($notifiers)]);
    }
}
