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
use doganoo\INotify\IReceiver;
use doganoo\INotify\ISender;
use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayLists\ArrayList;

/**
 * Class Notifier
 * @package doganoo\NotifierService\SNA
 */
abstract class Notifier implements INotifier {
    /** @var string $message */
    private $message = null;
    /** @var string $subject */
    private $subject = null;
    /** @var ArrayList $receiver */
    private $receiver = null;
    /** @var ISender $sender */
    private $sender = null;

    /**
     * Notifier constructor.
     */
    public function __construct() {
        $this->receiver = new ArrayList();
    }

    /**
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void {
        $this->message = $message;
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
     * @param IReceiver $receiver
     */
    public function addReceiver(IReceiver $receiver): void {
        $this->receiver->add($receiver);
    }

    /**
     * @return ArrayList
     */
    public function getReceiver(): ArrayList {
        return $this->receiver;
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

    /**
     * @return bool
     */
    public abstract function notify(): bool;


}