<?php
declare(strict_types=1);

namespace doganoo\INotify\Service;

use DateTime;
use DateTimeInterface;
use doganoo\INotify\Entity\Attachment\Attachment;
use doganoo\INotify\Entity\Header\Header;
use doganoo\INotify\Entity\Participant\Receiver\Receiver;
use doganoo\INotify\Entity\Participant\ReplyTo\ReplyTo;
use doganoo\INotify\Entity\Participant\Sender\Sender;
use doganoo\INotify\Entity\Queue\Item;

class QueueService {

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
            $item->addReplyTo(new ReplyTo($data['address'], $data['name']));
        }

        foreach ($receiver as $data) {
            $item->addReceiver(new Receiver($data['address'], $data['name']));
        }

        foreach ($cc as $data) {
            $item->addCarbonCopy(new Receiver($data['address'], $data['name']));
        }

        foreach ($bcc as $data) {
            $item->addBlindCarbonCopy(new Receiver($data['address'], $data['name']));
        }

        foreach ($attachment as $data) {
            $item->addAttachment(new Attachment($data['path'], $data['name']));
        }

        $item->setCreateTs(new DateTime());
        $item->setScheduleTs($scheduleTs);

        foreach ($headers as $data) {
            $item->addHeader(new Header($data['name'], $data['value']));
        }

        $item->setBody($body);
        $item->setAltBody($altBody);
        $item->setSubject($subject);
        $item->setCreateTs($createTs);

        return $item;
    }

}