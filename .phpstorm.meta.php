<?php

namespace PHPSTORM_META;

use Notify\NotifyManager;
use Notify\Envelope\Envelope;

override(Envelope::get(), type(0));

override(NotifyManager::notifier(''), map(['' => '@']));
expectedArguments(NotifyManager::notifier(), 0, 'toastr', 'pnotify', 'alert');
