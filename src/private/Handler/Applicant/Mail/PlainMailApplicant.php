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

namespace doganoo\IN\Handler\Applicant\Mail;

use doganoo\INotify\Handler\Applicant\Mail\IConfig;
use doganoo\INotify\Queue\INotification;
use doganoo\INotify\Service\Log\ILoggerService;
use PHPMailer\PHPMailer\Exception;
use function strip_tags;

/**
 * Class PlainMailApplicant
 *
 * @package doganoo\IN\Handler\Applicant\Mail
 * @author  Dogan Ucar <dogan@dogan-ucar.de>
 */
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

    /**
     * @param INotification $notification
     *
     * @return bool
     * @throws Exception
     */
    public function notify(INotification $notification): bool {
        $notification->setContent(
            strip_tags($notification->getContent())
        );
        return parent::notify($notification);
    }

}
