<?php
declare(strict_types=1);

namespace doganoo\INotify\Service;

use DateTime;
use doganoo\INotify\Entity\Log\Log;
use doganoo\INotify\Entity\Queue\Item;
use doganoo\INotify\Repository\ILogRepository;

class LogService {

    private ILogRepository $logRepository;

    public function __construct(ILogRepository $logRepository) {
        $this->logRepository = $logRepository;
    }

    public function toLog(Item $item): Log {
        $log = new Log();
        $log->setItem($item);
        $log->setCreateTs(new DateTime());
        $log->setSendTs($item->getScheduleTs());
        $log->setDeleteTs((new DateTime())->modify('+90 days'));
        return $log;
    }

    public function logItem(Log $log): Log {
        return $this->logRepository->store($log);
    }

}