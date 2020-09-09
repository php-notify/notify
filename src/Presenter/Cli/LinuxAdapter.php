<?php

namespace Yoeunes\Notify\Presenter\Cli;

class LinuxAdapter extends BaseAdapter
{
    /**
     * @inheritDoc
     */
    public function isSupported()
    {
        return in_array(PHP_OS, array('Linux', 'FreeBSD', 'NetBSD', 'OpenBSD', 'SunOS', 'DragonFly'));
    }

    /**
     * @inheritDoc
     */
    public function render(array $envelopes = array())
    {
        foreach ($envelopes as $envelope) {
            exec(sprintf('notify-send \
                --urgency="normal" \
                --app-name="notify" \
                --icon="%s" \
                "%s " "%s "',
                $this->getIcon($envelope),
                $envelope->getTitle() ?: $envelope->getType(),
                $envelope->getMessage()
            ));
        }
    }
}
