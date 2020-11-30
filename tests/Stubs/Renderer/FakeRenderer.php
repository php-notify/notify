<?php

namespace Notify\Tests\Stubs\Renderer;

use Notify\Envelope\Envelope;
use Notify\Renderer\HasOptionsInterface;
use Notify\Renderer\HasScriptsInterface;
use Notify\Renderer\HasStylesInterface;
use Notify\Renderer\RendererInterface;

class FakeRenderer implements RendererInterface, HasScriptsInterface, HasOptionsInterface, HasStylesInterface
{
    public function renderOptions()
    {
        return 'fake.options = []';
    }

    public function getScripts()
    {
        return array('jquery.min.js', 'fake.min.js');
    }

    public function getStyles()
    {
        return array('fake.min.css');
    }

    public function render(Envelope $envelope)
    {
        return sprintf(
            "fake.%s('%s', '%s');",
            $envelope->getType(),
            $envelope->getMessage(),
            $envelope->getTitle()
        );
    }
}
