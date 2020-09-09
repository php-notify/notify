<?php

namespace Yoeunes\Notify\Presenter\Cli;

interface CliAdapter
{
    /**
     * @return bool
     */
    public function isSupported();

    /**
     * @param \Yoeunes\Notify\Envelope\Envelope[] $envelopes
     */
    public function render(array $envelopes = array());
}
