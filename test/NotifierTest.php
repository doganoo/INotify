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

use doganoo\INotify\Object\NotificationList;
use Notifier\MailMock;
use Notifier\MockMailConfig;
use Notifier\MockQueue;
use Notifier\MockQueueConfig;
use Notifier\MockReceiver;
use Notifier\MockSender;
use PHPUnit\Framework\TestCase;

/**
 * Class NotifierTest
 */
class NotifierTest extends TestCase {
    /**
     * tests notifier
     */
    public function testMailNotifier() {
        $notifier = new MailMock();
        $notifier->setMessage("mock message");
        $notifier->setSender(new MockSender());
        $notifier->setSubject("mock subject");
        $notifier->addReceiver(new MockReceiver());
        $notifier->setConfig(new MockMailConfig());
        $this->assertTrue(true === $notifier->notify());
    }

    public function testQueue(){
        $notifier = new MailMock();
        $notifier->setMessage("mock message");
        $notifier->setSender(new MockSender());
        $notifier->setSubject("mock subject");
        $notifier->addReceiver(new MockReceiver());
        $notifier->setConfig(new MockMailConfig());

        $notificationList = new NotificationList();
        $notificationList->add($notifier);

        $mockQueue = new MockQueue(
            new MockQueueConfig()
            , $notificationList
        );
        $mockQueue->notifyAll();

        $this->assertTrue(true === $mockQueue->sentAllToDefault());

    }
}