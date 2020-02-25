<?php

namespace Yoeunes\Notify\Factories\Behaviours;

trait ScriptsAwareTrait
{
    public function getScripts()
    {
        if (!isset($this->config['scripts'])) {
            return [];
        }

        return $this->config['scripts'];
    }
}
