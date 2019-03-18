<?php


namespace Notifier;


use doganoo\INotify\Notification\INotifier;
use doganoo\INotify\Notification\Log\Log;
use doganoo\INotify\Object\ReceiverList;
use doganoo\INotify\Queue\IConfig;

class MockQueueConfig implements IConfig {

    /**
     * @return int
     */
    public function getEnvironment(): int {
        return IConfig::ENVIRONMENT_DEV;
    }

    /**
     * @return INotifier
     */
    public function getDefaultNotifier(): INotifier {
        return new Log();
    }

    /**
     * @return ReceiverList|null
     */
    public function getDefaultReceiver(): ?ReceiverList {
        $receiverList = new ReceiverList();
        $receiverList->add(new MockReceiver());
        return $receiverList;
    }
}