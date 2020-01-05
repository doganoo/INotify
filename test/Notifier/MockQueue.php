<?php
/**
 * MIT License
 *
 * Copyright (c) 2018 Dogan Ucar, <dogan@dogan-ucar.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace doganoo\INotify\Test\Notifier;

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
            $result              = $notifier;
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
     * @param string       $notifierName
     * @param string       $configName
     */
    public function logNotification(ReceiverList $receiver, string $notifierName, string $configName): void {
        /** @var IReceiver $r */
        foreach ($receiver as $r) {
            echo "sent mail to {$r->getDisplayname()} with notifier $notifierName and config $configName\n";
        }
    }

    public function sentAllToDefault(): bool {
        return $this->sentToDefault;
    }

}