<?php
declare(strict_types=1);


namespace doganoo\IN\Handler\Applicant\Mail;


use doganoo\INotify\Handler\Applicant\Mail\IConfig;
use doganoo\INotify\Notification\INotification;
use doganoo\INotify\Service\Log\ILoggerService;
use function strip_tags;

class PlainMailApplicant extends MailApplicant {

    /**
     * PlainMailApplicant constructor.
     *
     * @param ILoggerService $logger
     * @param IConfig|null   $config
     */
    public function __construct(
        ILoggerService $logger
        , ?IConfig $config = null
    ) {
        parent::__construct(
            $logger
            , $config
        );
        parent::setIsHTML(false);
    }


    public function notify(INotification $notification): bool {
        $notification->setContent(
            strip_tags($notification->getContent())
        );
        return parent::notify($notification);
    }

}
