<?php

namespace PHPSTORM_META;

use Yoeunes\Notify\NotifyManager;
use Yoeunes\Notify\Envelope\Envelope;

override(Envelope::get(), type(0));

override(NotifyManager::notifier(''), map(['' => '@']));
expectedArguments(NotifyManager::notifier(), 0, 'toastr', 'pnotify', 'alert');
