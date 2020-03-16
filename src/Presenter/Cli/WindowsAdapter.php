<?php

namespace Yoeunes\Notify\Presenter\Cli;

class WindowsAdapter implements CliAdapter
{
    public function isSupported()
    {
        return '\\' === DIRECTORY_SEPARATOR;
    }

    /**
     * @param \Yoeunes\Notify\Envelope\Envelope[] $envelopes
     */
    public function render(array $envelopes = array())
    {
        foreach ($envelopes as $envelope) {
            exec(sprintf('notify-send -u critical -i "%s" "%s"',
                $envelope->getTitle(),
                $envelope->getMessage()
            ));
        }
    }
}
