<?php
/**
 * Created by PhpStorm.
 * User: doganucar
 * Date: 2019-03-13
 * Time: 22:17
 */

namespace doganoo\INotify\Notification\Mail;

use doganoo\INotify\Notification\Notifier;
use doganoo\INotify\Participant\IReceiver;
use doganoo\PHPUtil\Log\Logger;
use PHPMailer\PHPMailer\PHPMailer;

class Mail extends Notifier
{
    /** @var PHPMailer $mailer */
    private $mailer = null;
    /** @var IConfig $mailConfig */
    private $mailConfig = null;

    /**
     * EmailNotifier constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->mailer = new PHPMailer(true);
        $this->setIsHTML(true);
    }

    /**
     * @param bool $html
     */
    protected function setIsHTML(bool $html): void {
        $this->mailer->isHTML($html);
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
     * @return IConfig
     */
    public function getMailConfiguration(): IConfig {
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
     * @param callable|null $callable
     */
    public function verbose(bool $verbose, callable $callable = null): void {
        if ($verbose) {
            $this->mailer->SMTPDebug = 2;
            if (null === $callable) {
                $callable = function ($message) {
                    Logger::debug($message);
                };
            }
            $this->mailer->Debugoutput = $callable;
        } else {
            $this->mailer->SMTPDebug = 0;
            $this->mailer->Debugoutput = null;
        }

    }

    /**
     * @param IConfig $mailConfig
     */
    public function setMailConfiguration(IConfig $mailConfig): void {
        $this->mailConfig = $mailConfig;
    }

}