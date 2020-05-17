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

namespace doganoo\IN\Queue;

use DateTime;
use doganoo\IN\Participant\ReceiverList;
use doganoo\INotify\Participant\IReceiver;
use doganoo\INotify\Participant\IReceiverList;
use doganoo\INotify\Participant\ISender;
use doganoo\INotify\Queue\INotification;
use doganoo\INotify\Queue\IType;
use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayLists\ArrayList;

/**
 * Class Queue
 *
 * @package doganoo\IN\Queue
 * @author  Dogan Ucar <dogan@dogan-ucar.de>
 */
class Notification implements INotification {

    /** @var int */
    private $id;
    /** @var string */
    private $subject;
    /** @var string */
    private $content;
    /** @var IType */
    private $type;
    /** @var bool */
    private $executed;
    /** @var IReceiverList|ArrayList */
    private $receiverList;
    /** @var int */
    private $delay;
    /** @var DateTime */
    private $createTs;
    /** @var DateTime|null */
    private $sendTs;
    /** @var int|null */
    private $notificationId;
    /** @var ISender */
    private $sender;

    /**
     * Notification constructor.
     */
    public function __construct() {
        $this->receiverList = new ReceiverList();
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSubject(): string {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void {
        $this->content = $content;
    }

    /**
     * @return IType
     */
    public function getType(): IType {
        return $this->type;
    }

    /**
     * @param IType $type
     */
    public function setType(IType $type): void {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isExecuted(): bool {
        return $this->executed;
    }

    /**
     * @param bool $executed
     */
    public function setExecuted(bool $executed): void {
        $this->executed = $executed;
    }

    /**
     * @return IReceiverList
     */
    public function getReceiverList(): IReceiverList {
        return $this->receiverList;
    }

    /**
     * @param IReceiverList $receiverList
     */
    public function setReceiverList(IReceiverList $receiverList): void {
        $this->receiverList = $receiverList;
    }

    /**
     * @return int
     */
    public function getDelay(): int {
        return $this->delay;
    }

    /**
     * @param int $delay
     */
    public function setDelay(int $delay): void {
        $this->delay = $delay;
    }

    /**
     * @return DateTime
     */
    public function getCreateTs(): DateTime {
        return $this->createTs;
    }

    /**
     * @param DateTime $createTs
     */
    public function setCreateTs(DateTime $createTs): void {
        $this->createTs = $createTs;
    }

    /**
     * @return DateTime|null
     */
    public function getSendTs(): ?DateTime {
        return $this->sendTs;
    }

    /**
     * @param DateTime|null $sendTs
     */
    public function setSendTs(?DateTime $sendTs): void {
        $this->sendTs = $sendTs;
    }

    /**
     * @return ISender
     */
    public function getSender(): ISender {
        return $this->sender;
    }

    /**
     * @param ISender $sender
     */
    public function setSender(ISender $sender): void {
        $this->sender = $sender;
    }

    public function addReceiver(IReceiver $receiver): void {
        $this->receiverList->add($receiver);
    }

    /**
     * @return int|null
     */
    public function getNotificationId(): ?int {
        return $this->notificationId;
    }

    /**
     * @param int|null $notificationId
     */
    public function setNotificationId(?int $notificationId): void {
        $this->notificationId = $notificationId;
    }

}
