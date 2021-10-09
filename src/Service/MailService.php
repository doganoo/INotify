<?php
declare(strict_types=1);

namespace doganoo\INotify\Service;

use doganoo\INotify\ConfigProvider;
use doganoo\INotify\Entity\Attachment\Attachment;
use doganoo\INotify\Entity\Participant\Receiver\Receiver;
use doganoo\INotify\Entity\Participant\ReplyTo\ReplyTo;
use doganoo\INotify\Entity\Queue\Item;
use Laminas\Config\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Psr\Log\LoggerInterface;

class MailService {

    private Config          $config;
    private LoggerInterface $logger;

    public function __construct(
        Config          $config,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->logger = $logger;
    }

    public function sendEmail(Item $item): Item {

        $mail            = new PHPMailer((bool) $this->config->get(ConfigProvider::MAILER_EXCEPTIONS_ENABLED));
        $mail->SMTPDebug = $this->config->get(ConfigProvider::MAILER_DEBUG_MODE) ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF;

        $mail->Debugoutput = $this->logger;
        if ($this->config->get(ConfigProvider::MAILER_SMTP_MODE)) {
            $mail->isSMTP();
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Host       = (string) $this->config->get(ConfigProvider::MAILER_SMTP_HOST);
            $mail->Username   = (string) $this->config->get(ConfigProvider::MAILER_SMTP_USERNAME);
            $mail->Password   = (string) $this->config->get(ConfigProvider::MAILER_SMTP_PASSWORD);
            $mail->Port       = (int) $this->config->get(ConfigProvider::MAILER_SMTP_PORT);
        }

        $mail->setFrom(
            $item->getSender()->getAddress(),
            $item->getSender()->getName()
        );

        /** @var Receiver $receiver */
        foreach ($item->getReceiver() as $receiver) {
            $mail->addAddress(
                $receiver->getAddress(),
                $receiver->getName()
            );
        }

        /** @var ReplyTo $replyTo */
        foreach ($item->getReplyTo() as $replyTo) {
            $mail->addReplyTo(
                $replyTo->getAddress(),
                $replyTo->getName()
            );
        }

        /** @var Receiver $carbonCopy */
        foreach ($item->getCarbonCopy() as $carbonCopy) {
            $mail->addCC(
                $carbonCopy->getAddress(),
                $carbonCopy->getName()
            );
        }

        /** @var Receiver $blindCarbonCopy */
        foreach ($item->getBlindCarbonCopy() as $blindCarbonCopy) {
            $mail->addBCC(
                $blindCarbonCopy->getAddress(),
                $blindCarbonCopy->getName()
            );
        }

        /** @var Attachment $attachment */
        foreach ($item->getAttachment() as $attachment) {
            $mail->addAttachment(
                $attachment->getPath(),
                $attachment->getName()
            );
        }

        $mail->isHTML((bool) $this->config->get(ConfigProvider::MAILER_HTML_MODE));
        $mail->Subject = $item->getSubject();
        $mail->Body    = $item->getBody();
        $mail->AltBody = $item->getAltBody();

        $logMessage = 'email sending not enabled';
        if ($this->config->get(ConfigProvider::MAILER_SENDING_ENABLED)) {
            $sent       = $mail->send();
            $logMessage = 'email sent: ' . (true === $sent) ? 'true' : 'false';
        }
        $this->logger->info($logMessage);

        return $item;
    }

}