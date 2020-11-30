<?php

namespace PHPSTORM_META;

override(\Notify\Envelope\Envelope::get(), type(0));
override(\Notify\Manager\ManagerInterface::make(0), map(['' => '@']));

registerArgumentsSet('notificationTypes',
    \Notify\Notification\NotificationInterface::TYPE_SUCCESS,
    \Notify\Notification\NotificationInterface::TYPE_ERROR,
    \Notify\Notification\NotificationInterface::TYPE_INFO,
    \Notify\Notification\NotificationInterface::TYPE_INFO,
);

expectedArguments(\Notify\Notification\NotificationBuilder::type(), 1, argumentsSet('notificationTypes'));
expectedReturnValues(\Notify\Notification\NotificationInterface::setType(), 1, argumentsSet('notificationTypes'));
expectedReturnValues(\Notify\Notification\NotificationInterface::getType(), argumentsSet('notificationTypes'));
