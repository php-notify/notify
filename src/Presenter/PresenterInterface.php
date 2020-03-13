<?php

namespace Yoeunes\Notify\Presenter;

use Yoeunes\Notify\Envelope\Envelope;

interface PresenterInterface
{
    /**
     * @param \Yoeunes\Notify\Envelope\Envelope $envelope
     *
     * @return mixed
     */
    public function render(Envelope $envelope);

    /**
     * @param \Yoeunes\Notify\Envelope\Envelope $envelope
     * @param array                             $context
     *
     * @return bool
     */
    public function support(Envelope $envelope, array $context = array());
}
