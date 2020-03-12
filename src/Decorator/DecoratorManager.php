<?php

namespace Yoeunes\Notify\Decorator;

use Yoeunes\Notify\Decorator\Presenter\PresenterInterface;

final class DecoratorManager
{
    private $presenters;

    public function __construct(array $presenters)
    {
        $this->presenters = $presenters;
    }

    public function addPresenter(PresenterInterface $presenter)
    {
        $this->presenters[] = $presenter;
    }
}
