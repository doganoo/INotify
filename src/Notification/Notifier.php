<?php
/**
 * Created by PhpStorm.
 * User: doganucar
 * Date: 2019-03-13
 * Time: 22:19
 */

namespace doganoo\INotify\Notification;


use doganoo\INotify\Object\ReceiverList;
use doganoo\INotify\Participant\IReceiver;
use doganoo\INotify\Participant\ISender;

/**
* Class Notification
 * @package doganoo\NotifierService\SNA
*/
abstract class Notifier implements INotifier {
    /** @var string $message */
    private $message = null;
    /** @var string $subject */
    private $subject = null;
    /** @var ReceiverList $receiver */
    private $receiver = null;
    /** @var ISender $sender */
    private $sender = null;

    /**
     * Notification constructor.
     */
    public function __construct() {
        $this->receiver = new ReceiverList();
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
     * @return ReceiverList
     */
    public function getReceiver(): ReceiverList {
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

    public function overrideReceiver(ReceiverList $receiver): void {
        $this->receiver = $receiver;
    }

    /**
     * @return bool
     */
    public abstract function notify(): bool;


}