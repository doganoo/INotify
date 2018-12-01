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


use doganoo\INotify\IMailConfig;
use doganoo\INotify\IReceiver;
use doganoo\PHPUtil\Log\Logger;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class EmailNotifier
 * @package doganoo\NotifierService\SNA
 */
class EmailNotifier extends Notifier {
    /** @var PHPMailer $mailer */
    private $mailer = null;
    /** @var IMailConfig $mailConfig */
    private $mailConfig = null;

    /**
     * EmailNotifier constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->mailer = new PHPMailer(true);
    }

    /**
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function notify(): bool {
        $this->mailer->setFrom(
            parent::getSender()->getEmail()
            , parent::getSender()->getDisplayname()
        );
        /** @var IReceiver $receiver */
        foreach (parent::getReceiver() as $receiver) {
            $this->mailer->addAddress(
                $receiver->getEmail()
                , $receiver->getDisplayname()
            );
        }
        $this->mailer->Subject = parent::getSubject();
        $this->mailer->Body = parent::getMessage();
        return $this->mailer->send();
    }

    /**
     * enables PHPMailer SMTP
     */
    public function enableSMTP(): void {
        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = true;
        $this->mailer->Host = $this->getMailConfiguration()->getSMTPHost();
        $this->mailer->Port = $this->getMailConfiguration()->getSMTPPort();
        $this->mailer->SMTPSecure = $this->getMailConfiguration()->getSMTPProtocol();
        $this->mailer->Username = parent::getSender()->getEmail();
        $this->mailer->Password = parent::getSender()->getPassword();
        $this->mailer->SMTPOptions =
            [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];
    }

    /**
     * @return IMailConfig
     */
    public function getMailConfiguration(): IMailConfig {
        return $this->mailConfig;
    }

    /**
     * @return string
     */
    public function errorInfo(): string {
        return $this->mailer->ErrorInfo;
    }

    /**
     * @param bool $verbose
     */
    public function verbose(bool $verbose): void {
        if ($verbose) {
            $this->mailer->SMTPDebug = 2;
            $this->mailer->Debugoutput = function ($message) {
                Logger::debug($message);
            };
        } else {
            $this->mailer->SMTPDebug = 0;
            $this->mailer->Debugoutput = null;
        }

    }

    /**
     * @param IMailConfig $mailConfig
     */
    public function setMailConfiguration(IMailConfig $mailConfig): void {
        $this->mailConfig = $mailConfig;
    }

    /**
     * @param bool $html
     */
    protected function setIsHTML(bool $html): void {
        $this->mailer->isHTML($html);
    }

}