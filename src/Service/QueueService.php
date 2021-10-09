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

        foreach ($replyTo as $address => $name) {
            $item->addReplyTo(new ReplyTo($address, $name));
        }

        foreach ($receiver as $address => $name) {
            $item->addReceiver(new Receiver($address, $name));
        }

        foreach ($cc as $address => $name) {
            $item->addCarbonCopy(new Receiver($address, $name));
        }

        foreach ($bcc as $address => $name) {
            $item->addBlindCarbonCopy(new Receiver($address, $name));
        }

        foreach ($attachment as $path => $name) {
            $item->addAttachment(new Attachment($path, $name));
        }

        $item->setCreateTs(new DateTime());
        $item->setScheduleTs($scheduleTs);

        foreach ($headers as $name => $value) {
            $item->addHeader(new Header($name, $value));
        }

        $item->setBody($body);
        $item->setAltBody($altBody);
        $item->setSubject($subject);
        $item->setCreateTs($createTs);

        return $item;
    }

}