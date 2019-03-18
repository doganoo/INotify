<?php


namespace Notifier;


use doganoo\INotify\Notification\INotifier;
use doganoo\INotify\Object\NotificationList;
use doganoo\INotify\Object\ReceiverList;
use doganoo\INotify\Participant\IReceiver;
use doganoo\INotify\Queue\IConfig;
use doganoo\INotify\Queue\IQueue;
use doganoo\PHPUtil\Util\ClassUtil;

class MockQueue implements IQueue {

    private $list = null;

    private $config = null;

    private $sentToDefault = false;

    public function __construct(
        IConfig $config
        , NotificationList $list
    ) {
        $this->config = $config;
        $this->storeList($list);
    }

    /**
     * @param NotificationList $list
     * @return bool
     */
    public function storeList(NotificationList $list): bool {
        $this->list = $list;
        return true;
    }

    /**
     * @return NotificationList
     */
    public function getList(): NotificationList {
        return $this->list;
    }

    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function notifyAll(): bool {

        /** @var INotifier $notifier */
        foreach ($this->list as $notifier) {
            $result = $notifier;
            $this->sentToDefault = false;
            if ($this->isTest()) {
                $result = $this->config->getDefaultNotifier();
                $result->copyFrom($notifier);
                $result->overrideReceiver($this->config->getDefaultReceiver());
                $this->sentToDefault = true;
            }
            $result->notify();

            $this->logNotification(
                $result->getReceiver()
                , ClassUtil::getClassName($result)
                , ClassUtil::getClassName($this->getConfig())
            );

        }
        return true;
    }

    private function isTest(): bool {
        return ($this->getConfig()->getEnvironment() === IConfig::ENVIRONMENT_DEV) || ($this->getConfig()->getEnvironment() === IConfig::ENVIRONMENT_TEST);
    }

    /**
     * @return IConfig|null
     */
    public function getConfig(): ?IConfig {
        return $this->config;
    }

    /**
     * @param ReceiverList $receiver
     * @param string $notifierName
     * @param string $configName
     */
    public function logNotification(ReceiverList $receiver, string $notifierName, string $configName): void {
        /** @var IReceiver $r */
        foreach ($receiver as $r) {
            echo "sent mail to {$r->getDisplayname()} with notifier $notifierName and config $configName\n";
        }
    }

    public function sentAllToDefault():bool {
        return $this->sentToDefault;
    }
}