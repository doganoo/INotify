<?php


namespace doganoo\INotify\Notification\Log;


use doganoo\INotify\Notification\Notifier;
use doganoo\INotify\Participant\IReceiver;
use doganoo\PHPUtil\Log\FileLogger;

class Log extends Notifier {

    public function __construct() {
        FileLogger::setPath("log.log");
        parent::__construct();
    }

    /**
     * @return bool
     */
    public function notify(): bool {
        $x = parent::getSender()->getDisplayname() .
            " [" . parent::getSender()->getEmail() .
            "] has sent an email with the following properties: " .
            parent::getMessage() . " " .
            parent::getSubject() . " to the following receiver: ";

        /** @var IReceiver $receiver */
        foreach (parent::getReceiver() as $receiver) {
            $x .= $receiver->getEmail() . " " . $receiver->getDisplayname() . " ";
        }
        FileLogger::debug($x);
        return true;
    }
}