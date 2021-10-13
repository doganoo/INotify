<?php
declare(strict_types=1);

namespace doganoo\INotify\Service;

use DateTimeInterface;
use doganoo\DI\Email\IEmailService;
use doganoo\DI\HTML\IPurifierService;
use doganoo\INotify\Entity\Attachment\Attachment;
use doganoo\INotify\Entity\Header\Header;
use doganoo\INotify\Entity\Participant\Receiver\Receiver;
use doganoo\INotify\Entity\Participant\ReplyTo\ReplyTo;
use doganoo\INotify\Entity\Participant\Sender\Sender;
use doganoo\INotify\Entity\Queue\Item;
use Laminas\Config\Config;

class QueueService {

    private IEmailService    $emailService;
    private IPurifierService $purifierService;
    private Config           $config;

    public function __construct(
        IEmailService      $emailService
        , IPurifierService $purifierService
        , Config           $config
    ) {
        $this->emailService    = $emailService;
        $this->purifierService = $purifierService;
        $this->config          = $config;
    }

    public function toItem(
        string            $body,
        string            $altBody,
        Sender            $sender,
        DateTimeInterface $scheduleTs,
        DateTimeInterface $createTs,
        string            $subject,
        array             $replyTo,
        array             $receiver,
        array             $cc,
        array             $bcc,
        array             $attachment,
        array             $headers
    ): Item {
        $item = new Item();
        $item->setSender($sender);

        foreach ($replyTo as $data) {
            $address = $data['address'] ?? '';
            if (false === $this->emailService->isEmailAddress($address)) {
                continue;
            }
            $name = $data['name'] ?? '';
            $name = $this->purifierService->encodeEntities($name);
            $item->addReplyTo(new ReplyTo($address, $name));
        }

        foreach ($receiver as $data) {
            $address = $data['address'] ?? '';
            if (false === $this->emailService->isEmailAddress($address)) {
                continue;
            }
            $name = $data['name'] ?? '';
            $name = $this->purifierService->encodeEntities($name);
            $item->addReceiver(new Receiver($address, $name));
        }

        foreach ($cc as $data) {
            $address = $data['address'] ?? '';
            if (false === $this->emailService->isEmailAddress($address)) {
                continue;
            }
            $name = $data['name'] ?? '';
            $name = $this->purifierService->encodeEntities($name);
            $item->addCarbonCopy(new Receiver($address, $name));
        }

        foreach ($bcc as $data) {
            $address = $data['address'] ?? '';
            if (false === $this->emailService->isEmailAddress($address)) {
                continue;
            }
            $name = $data['name'] ?? '';
            $name = $this->purifierService->encodeEntities($name);
            $item->addBlindCarbonCopy(new Receiver($address, $name));
        }

        foreach ($attachment as $data) {
            $name = $data['name'] ?? '';
            $name = $this->purifierService->encodeEntities($name);
            $path = realpath($data['path']);

            if (false === is_string($path)) {
                continue;
            }

            $item->addAttachment(new Attachment($path, $name));
        }

        $item->setScheduleTs($scheduleTs);

        $possibleHeaders = $this->config->get('headers');
        foreach ($headers as $data) {
            $name = $data['name'] ?? '';
            if (false === in_array($name, $possibleHeaders, true)) {
                continue;
            }
            $value = trim(preg_replace('/\s\s+/', '', $data['value']));
            $item->addHeader(new Header($name, $value));
        }

        $item->setBody(
            $this->purifierService->purify($body)
        );
        $item->setAltBody($altBody);
        $item->setSubject(
            $this->purifierService->purify($subject)
        );
        $item->setCreateTs($createTs);

        return $item;
    }

}