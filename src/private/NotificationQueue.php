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

namespace doganoo\PINotify;

use doganoo\INotify\INotifier;
use doganoo\PHPAlgorithms\Datastructure\Stackqueue\Queue;

/**
 * Class NotificationQueue
 * @package doganoo\NotifierService\SNA
 */
class NotificationQueue extends Queue {
    /** @var bool $sendable */
    private $sendable = true;

    public function __construct(bool $sendable) {
        $this->sendable = $sendable;
    }

    /**
     * enqueues a new INotifier instance
     *
     * @param $item
     * @return bool
     */
    public function enqueue($item): bool {
        if ($item instanceof INotifier) {
            return parent::enqueue($item);
        }
        return false;
    }

    /**
     * processes the queues
     */
    public function process(): void {
        while (!parent::isEmpty() && $this->sendable) {
            /** @var INotifier $notifier */
            $notifier = parent::dequeue();
            $notifier->notify();
        }
    }
}