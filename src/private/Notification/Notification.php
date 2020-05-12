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

namespace doganoo\IN\Notification;

use DateTime;
use doganoo\INotify\Notification\INotification;
use doganoo\INotify\Notification\Type\IType;
use doganoo\INotify\Notification\Type\ITypeList;
use doganoo\INotify\Participant\IReceiver;
use doganoo\INotify\Participant\IReceiverList;
use doganoo\INotify\Participant\ISender;
use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayLists\ArrayList;

class Notification implements INotification {

    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var DateTime */
    private $createTs;
    /** @var ISender */
    private $sender;
    /** @var string */
    private $content;
    /** @var string */
    private $subject;
    /** @var bool */
    private $executed;
    /** @var ITypeList|ArrayList */
    private $types;
    /** @var IReceiverList */
    private $receiverList;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getCreateTs(): DateTime {
        return $this->createTs;
    }

    public function setCreateTs(DateTime $createTs): void {
        $this->createTs = $createTs;
    }

    public function getSender(): ISender {
        return $this->sender;
    }

    public function setSender(ISender $sender): void {
        $this->sender = $sender;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function getSubject(): string {
        return $this->subject;
    }

    public function setSubject(string $subject): void {
        $this->subject = $subject;
    }

    public function getTypes(): ITypeList {
        return $this->types;
    }

    public function setTypes(ITypeList $typeList): void {
        $this->types = $typeList;
    }

    public function addType(IType $type): void {
        $this->types->add($type);
    }

    public function isExecuted(): bool {
        return $this->executed;
    }

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

    public function addReceiver(IReceiver $receiver): void {
        $this->receiverList->add($receiver);
    }

}
