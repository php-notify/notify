<?php

namespace Yoeunes\Notify\Presenter\Cli;

class LinuxAdapter implements CliAdapter
{
    public function isSupported()
    {
        return in_array(PHP_OS, array('Linux', 'FreeBSD', 'NetBSD', 'OpenBSD', 'SunOS', 'DragonFly'));
    }

    /**
     * @param \Yoeunes\Notify\Envelope\Envelope[] $envelopes
     */
    public function render(array $envelopes = array())
    {
        foreach ($envelopes as $envelope) {
            exec(sprintf('notify-send --urgency="normal" --expire-time=300 --icon="icon.jpeg" --app-name="notify" "%s" "%s"',
                $envelope->getTitle(),
                $envelope->getMessage()
            ));
        }
    }
}
