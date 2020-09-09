<?php

namespace Yoeunes\Notify\Presenter\Cli;

use Yoeunes\Notify\Envelope\Envelope;

abstract class BaseAdapter implements CliAdapter
{
    public function getIcon(Envelope $envelope)
    {
        $iconFile = __DIR__.'/../../../resources/icons/'.$envelope->getType().'.png';

        if (file_exists($iconFile)) {
            return $iconFile;
        }

        return __DIR__.'/../../../resources/icons/info.png';
    }
}
