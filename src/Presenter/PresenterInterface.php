<?php

namespace Yoeunes\Notify\Presenter;

interface PresenterInterface
{
    /**
     * @param array $context
     *
     * @return bool
     */
    public function support(array $context);

    /**
     * @return string
     */
    public function render();
}
