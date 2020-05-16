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

namespace doganoo\IN\Handler\Applicant\Log;

use doganoo\IN\Handler\Applicant\Applicant;
use doganoo\INotify\Participant\IReceiver;
use doganoo\INotify\Queue\INotification;
use doganoo\INotify\Service\Log\ILoggerService;

/**
 * Class LogApplicant
 *
 * @package doganoo\IN\Handler\Applicant\Log
 * @author  Dogan Ucar <dogan@dogan-ucar.de>
 */
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
