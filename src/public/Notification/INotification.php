<?php
declare(strict_types=1);
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

namespace doganoo\INotify\Notification;

use DateTime;
use doganoo\INotify\Notification\Type\ITypeList;
use doganoo\INotify\Participant\IReceiverList;
use doganoo\INotify\Participant\ISender;
use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayLists\ArrayList;

/**
 * Interface INotification
 *
 * @package doganoo\INotify\Notification
 */
interface INotification {

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return ISender
     */
    public function getSender(): ISender;

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @return string
     */
    public function getSubject(): string;

    /**
     * @return ITypeList
     */
    public function getTypes(): ITypeList;

    /**
     * @return bool
     */
    public function isExecuted(): bool;

    /**
     * @param bool $executed
     */
    public function setExecuted(bool $executed): void;

    /**
     * @return DateTime
     */
    public function getCreateTs(): DateTime;

    /**
     * @return IReceiverList|ArrayList
     */
    public function getReceiverList(): IReceiverList;

    /**
     * @return int|null
     */
    public function getDelay(): ?int;

    /**
     * @return int|null
     */
    public function getQueueId(): ?int;

}
