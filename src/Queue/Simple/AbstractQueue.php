<?php
/**
 * Created by PhpStorm.
 * User: doganucar
 * Date: 2019-03-13
 * Time: 22:53
 */

namespace doganoo\INotify\Queue\Simple;


use doganoo\INotify\Notification\INotifier;
use doganoo\INotify\Object\NotificationList;
use doganoo\INotify\Object\ReceiverList;
use doganoo\INotify\Participant\IReceiver;
use doganoo\INotify\Queue\IConfig;
use doganoo\INotify\Queue\IQueue;
use doganoo\PHPUtil\Log\FileLogger;
use doganoo\PHPUtil\Util\ClassUtil;

abstract class AbstractQueue implements IQueue
{
    private $config = null;

    public function __construct() {
        $this->config = new SimpleConfig();
    }

    public function notifyAll(): bool{

        /** @var NotificationList $list */
        $list = $this->getList();
        $defaultReceiver = null;

        if (
            $this->config->getEnvironment() === IConfig::ENVIRONMENT_DEV
            || $this->config->getEnvironment() === IConfig::ENVIRONMENT_TEST
        ){
            $defaultReceiver = $this->config->getDefaultReceiver();
        }

        /** @var INotifier $notifier */
        foreach ($list as $notifier){
            if (null !== $defaultReceiver){
                $notifier->overrideReceiver($defaultReceiver);
            }
            $notifier->notify();
            $this->logNotification(
                $notifier->getReceiver()
                , ClassUtil::getClassName($notifier)
                , SimpleConfig::class
            );
        }

    }

    public function getConfig(): ?IConfig{
        return $this->config;
    }

    public function logNotification(ReceiverList $receiverList, string $notifierName, string $configName): void{

        /** @var IReceiver $receiver */
        foreach ($receiverList as $receiver){
            FileLogger::debug("sent mail to " . $receiver->getDisplayname() . " with notifier $notifierName and config $configName");
        }
    }

}