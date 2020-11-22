<?php

namespace PHPSTORM_META;

use Notify\Envelope\Envelope;
use Notify\Presenter\PresenterManager;
use Notify\Producer\ProducerManager;
use Notify\Renderer\RendererManager;

override(Envelope::get(), type(0));

override(ProducerManager::make(''), map(['' => '@']));
override(RendererManager::make(''), map(['' => '@']));
override(PresenterManager::make(''), map(['' => '@']));
