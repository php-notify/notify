<?php

namespace Yoeunes\Notify\Factory\Behaviour;

interface ScriptableInterface
{
    /**
     * @return array<int, string>
     */
    public function getScripts();
}
