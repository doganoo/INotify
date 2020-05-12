<?php
declare(strict_types=1);


namespace doganoo\IN\Handler\Applicant\Log;


use doganoo\IN\Handler\Applicant\Applicant;
use doganoo\INotify\Notification\INotification;
use doganoo\INotify\Participant\IReceiver;
use doganoo\INotify\Service\Log\ILoggerService;

class LogApplicant extends Applicant {

    /** @var ILoggerService */
    private $logger;

    public function __construct(ILoggerService $logger) {
        $this->logger = $logger;
    }

    /**
     * @param INotification $notification
     *
     * @return bool
     */
    public function notify(INotification $notification): bool {
        $logMessage = $notification->getSender()->getDisplayName() .
            " [" . $notification->getSender()->getEmail() .
            "] has sent an email with the following properties: " .
            $notification->getContent() . " " .
            $notification->getSubject() . " to the following receiver: ";

        /** @var IReceiver $receiver */
        foreach ($notification->getReceiverList() as $receiver) {
            $logMessage .= $receiver->getEmail() . " " . $receiver->getDisplayName() . " ";
        }
        $this->logger->log(LogApplicant::class, $logMessage, ILoggerService::DEBUG);
        return true;
    }

}
