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

use doganoo\IN\Handler\Applicant\Applicant;
use doganoo\INotify\Handler\Applicant\Mail\IConfig;
use doganoo\INotify\Handler\Applicant\Mail\IMailApplicant;
use doganoo\INotify\Notification\INotification;
use doganoo\INotify\Participant\IReceiver;
use doganoo\INotify\Participant\ISender;
use doganoo\INotify\Service\Log\ILoggerService;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailApplicant extends Applicant implements IMailApplicant {

    /** @var PHPMailer $mailer */
    private $mailer;
    /** @var IConfig|null $config */
    private $config = null;
    /** @var ILoggerService */
    private $logger;

    /**
     * MailApplicant constructor.
     *
     * @param ILoggerService $logger
     * @param IConfig|null   $config
     */
    public function __construct(
        ILoggerService $logger
        , ?IConfig $config = null
    ) {
        $this->mailer = new PHPMailer(true);
        $this->setIsHTML(true);
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * @param bool $html
     */
    protected function setIsHTML(bool $html): void {
        $this->mailer->isHTML($html);
    }

    /**
     * @param INotification $notification
     *
     * @return bool
     * @throws Exception
     */
    public function notify(INotification $notification): bool {

        if (null !== $this->config) {
            $this->enableSMTP($notification->getSender());
        }

        $this->mailer->setFrom(
            $notification->getSender()->getEmail()
            , $notification->getSender()->getDisplayName()
        );

        /** @var IReceiver $receiver */
        foreach ($notification->getReceiverList() as $receiver) {
            $this->mailer->addAddress(
                $receiver->getEmail()
                , $receiver->getDisplayName()
            );
        }

        $this->mailer->Subject = $notification->getSubject();
        $this->mailer->Body    = $notification->getContent();
        return $this->mailer->send();
    }

    /**
     * @param ISender $sender
     */
    private function enableSMTP(ISender $sender): void {
        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth    = true;
        $this->mailer->Host        = $this->config->getSMTPHost();
        $this->mailer->Port        = $this->config->getSMTPPort();
        $this->mailer->SMTPSecure  = $this->config->getSMTPProtocol();
        $this->mailer->Username    = $sender->getEmail();
        $this->mailer->Password    = $sender->getPassword();
        $this->mailer->SMTPOptions =
            [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                ]
            ];
    }

    /**
     * @return string
     */
    public function errorInfo(): string {
        return $this->mailer->ErrorInfo;
    }

    /**
     * @param bool          $verbose
     * @param callable|null $callable
     */
    public function verbose(bool $verbose, callable $callable = null): void {
        if ($verbose) {
            $this->mailer->SMTPDebug = 2;
            if (null === $callable) {
                $callable = function ($message) {
                    $this->logger->log(MailApplicant::class, $message, ILoggerService::DEBUG);
                };
            }
            $this->mailer->Debugoutput = $callable;
        } else {
            $this->mailer->SMTPDebug   = 0;
            $this->mailer->Debugoutput = null;
        }

    }

}
