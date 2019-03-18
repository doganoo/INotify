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

namespace Notifier;


use doganoo\INotify\Notification\Mail\IConfig;
use doganoo\INotify\Notification\Notifier;
use doganoo\INotify\Participant\ISender;

/**
 * Class MailNotifierMock
 * @package Notifier
 */
class MailMock extends Notifier {
    /** @var IConfig $config */
    private $config = null;

    /**
     * @return bool
     */
    public function notify(): bool {
        if (!parent::getSender() instanceof ISender) return false;
        if (!parent::getReceiver()->size() > 1) return false;
        if (!parent::getSender() instanceof ISender) return false;
        if (!parent::getSender() instanceof ISender) return false;
        if (!$this->config instanceof IConfig) return false;
        return true;
    }

    /**
     * @param IConfig $config
     */
    public function setConfig(IConfig $config): void {
        $this->config = $config;
    }
}