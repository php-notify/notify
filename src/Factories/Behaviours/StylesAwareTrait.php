<?php

namespace Yoeunes\Notify\Factories\Behaviours;

trait StylesAwareTrait
{
    public function getStyles()
    {
        if (!isset($this->config['styles'])) {
            return [];
        }

        return $this->config['styles'];
    }
}
