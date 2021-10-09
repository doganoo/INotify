<?php
declare(strict_types=1);

namespace doganoo\INotify\Handler;

use doganoo\INotify\Entity\Queue\Item;
use doganoo\INotify\Repository\IQueueRepository;
use doganoo\INotify\Service\LogService;
use doganoo\INotify\Service\MailService;

class QueueHandler {

    private IQueueRepository $queueRepository;
    private MailService      $mailService;
    private LogService       $logService;

    public function __construct(
        IQueueRepository $queueRepository,
        MailService      $mailService,
        LogService       $logService
    ) {
        $this->queueRepository = $queueRepository;
        $this->mailService     = $mailService;
        $this->logService      = $logService;
    }

    public function run(): void {
        $queueList = $this->queueRepository->getAll();

        /** @var Item $item */
        foreach ($queueList as $item) {
            $item = $this->mailService->sendEmail($item);
            $log  = $this->logService->toLog($item);
            $this->logService->logItem($log);
        }

    }

}