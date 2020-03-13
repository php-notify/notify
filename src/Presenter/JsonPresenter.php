<?php

namespace Yoeunes\Notify\Presenter;

use Yoeunes\Notify\Envelope\Envelope;

final class JsonPresenter implements PresenterInterface
{
    public function render(Envelope $envelope)
    {
        var_dump($envelope);die;
    }

    public function support(Envelope $envelope, array $context = array())
    {
        return false;
    }
}
