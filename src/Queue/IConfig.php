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

namespace doganoo\INotify\Queue;


use doganoo\INotify\Notification\INotifier;
use doganoo\INotify\Object\ReceiverList;

/**
 * Interface IConfig
 * @package doganoo\INotify\Queue
 */
interface IConfig {
    /** @var int ENVIRONMENT_DEV */
    public const ENVIRONMENT_DEV = 1;

    /** @var int ENVIRONMENT_TEST */
    public const ENVIRONMENT_TEST = 2;

    /** @var int ENVIRONMENT_PROD */
    public const ENVIRONMENT_PROD = 3;

    /**
     * @return int
     */
    public function getEnvironment(): int;

    /**
     * @return INotifier
     */
    public function getDefaultNotifier(): INotifier;

    /**
     * @return ReceiverList|null
     */
    public function getDefaultReceiver(): ?ReceiverList;

}