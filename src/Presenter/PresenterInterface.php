<?php

namespace Notify\Presenter;

interface PresenterInterface
{
    /**
     * @param array $context
     *
     * @return bool
     */
    public function support(array $context);

    /**
     * @return string|null
     */
    public function render();
}
