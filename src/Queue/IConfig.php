<?php
/**
 * Created by PhpStorm.
 * User: doganucar
 * Date: 2019-03-13
 * Time: 22:41
 */

namespace doganoo\INotify\Queue;


use doganoo\INotify\Notification\INotifier;
use doganoo\INotify\Object\ReceiverList;

interface IConfig
{
    public const ENVIRONMENT_DEV = 1;
    public const ENVIRONMENT_TEST = 2;
    public const ENVIRONMENT_PROD = 3;

    public function getEnvironment(): int;

    public function getDefaultNotifier(): INotifier;

    public function getDefaultReceiver(): ?ReceiverList;


}