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
     * @param string $criteria
     *
     * @return string
     */
    public function render($criteria = 'default');
}
