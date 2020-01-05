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

namespace doganoo\INotify\Queue\Simple;

use doganoo\INotify\Notification\INotifier;
use doganoo\INotify\Object\NotificationList;
use doganoo\INotify\Object\ReceiverList;
use doganoo\INotify\Participant\IReceiver;
use doganoo\INotify\Queue\IConfig;
use doganoo\INotify\Queue\IQueue;
use doganoo\PHPUtil\Log\FileLogger;
use doganoo\PHPUtil\Util\ClassUtil;

/**
 * Class AbstractQueue
 * @package doganoo\INotify\Queue\Simple
 */
abstract class AbstractQueue implements IQueue {

    /** @var SimpleConfig|null $config */
    private $config = null;

    /**
     * AbstractQueue constructor.
     */
    public function __construct() {
        $this->config = new SimpleConfig();
    }

    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function notifyAll(): bool {

        /** @var NotificationList $list */
        $list            = $this->getList();
        $defaultReceiver = null;

        if (
            $this->config->getEnvironment() === IConfig::ENVIRONMENT_DEV
            || $this->config->getEnvironment() === IConfig::ENVIRONMENT_TEST
        ) {
            $defaultReceiver = $this->config->getDefaultReceiver();
        }

        /** @var INotifier $notifier */
        foreach ($list as $notifier) {
            if (null !== $defaultReceiver) {
                $notifier->overrideReceiver($defaultReceiver);
            }
            $defaultNotifier = $this->getConfig()->getDefaultNotifier();
            $defaultNotifier->copyFrom($notifier);

            $defaultNotifier->notify();
            $this->logNotification(
                $notifier->getReceiver()
                , ClassUtil::getClassName($notifier)
                , SimpleConfig::class
            );
        }
        return true;
    }

    /**
     * @return IConfig|null
     */
    public function getConfig(): ?IConfig {
        return $this->config;
    }

    /**
     * @param ReceiverList $receiverList
     * @param string       $notifierName
     * @param string       $configName
     */
    public function logNotification(ReceiverList $receiverList, string $notifierName, string $configName): void {

        /** @var IReceiver $receiver */
        foreach ($receiverList as $receiver) {
            FileLogger::debug("sent mail to " . $receiver->getDisplayname() . " with notifier $notifierName and config $configName");
        }
    }

}