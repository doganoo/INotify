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

namespace doganoo\IN\Notification\Type;

use DateTime;
use doganoo\IN\Participant\ReceiverList;
use doganoo\INotify\Notification\Type\IType;
use doganoo\INotify\Participant\IReceiver;
use doganoo\INotify\Participant\IReceiverList;
use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayLists\ArrayList;
use doganoo\SimpleRBAC\Common\IPermission;

/**
 * Class Type
 *
 * @package doganoo\IN\Notification\Type
 * @author  Dogan Ucar <dogan@dogan-ucar.de>
 */
class Type implements IType {

    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var bool */
    private $mandatory;
    /** @var IPermission */
    private $permission;
    /** @var DateTime */
    private $createTs;
    /** @var IReceiverList|ArrayList */
    private $receiverList;

    public function __construct() {
        $this->receiverList = new ReceiverList();
    }

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

    public function isMandatory(): bool {
        return $this->mandatory;
    }

    public function setMandatory(bool $mandatory): void {
        $this->mandatory = $mandatory;
    }

    public function getPermission(): IPermission {
        return $this->permission;
    }

    public function setPermission(IPermission $permission): void {
        $this->permission = $permission;
    }

    public function getCreateTs(): DateTime {
        return $this->createTs;
    }

    public function setCreateTs(DateTime $createTs): void {
        $this->createTs = $createTs;
    }

    public function getReceiverList(): IReceiverList {
        return $this->receiverList;
    }

    public function setReceiverList(IReceiverList $receiverList): void {
        $this->receiverList = $receiverList;
    }

    public function addReceiver(IReceiver $user): void {
        $this->receiverList->add($user);
    }

}
