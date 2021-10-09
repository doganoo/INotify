<?php
declare(strict_types=1);

namespace doganoo\INotify\Entity\Queue;

use DateTimeInterface;
use doganoo\INotify\Entity\Attachment\Attachment;
use doganoo\INotify\Entity\Header\Header;
use doganoo\INotify\Entity\IJsonObject;
use doganoo\INotify\Entity\Participant\Receiver\Receiver;
use doganoo\INotify\Entity\Participant\ReplyTo\ReplyTo;
use doganoo\INotify\Entity\Participant\Sender\Sender;
use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayList\ArrayList;

class Item implements IJsonObject {

    private int               $id;
    private Sender            $sender;
    private ArrayList         $replyTo;
    private ArrayList         $receiver;
    private ArrayList         $carbonCopy;
    private ArrayList         $blindCarbonCopy;
    private ArrayList         $attachment;
    private DateTimeInterface $createTs;
    private DateTimeInterface $scheduleTs;
    private ArrayList         $headers;
    private string            $body;
    private string            $altBody;
    private string            $subject;

    public function __construct() {
        $this->replyTo         = new ArrayList();
        $this->receiver        = new ArrayList();
        $this->carbonCopy      = new ArrayList();
        $this->blindCarbonCopy = new ArrayList();
        $this->attachment      = new ArrayList();
        $this->headers         = new ArrayList();
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return Sender
     */
    public function getSender(): Sender {
        return $this->sender;
    }

    /**
     * @param Sender $sender
     */
    public function setSender(Sender $sender): void {
        $this->sender = $sender;
    }

    /**
     * @return ArrayList
     */
    public function getReceiver(): ArrayList {
        return $this->receiver;
    }

    /**
     * @param Receiver $receiver
     */
    public function addReceiver(Receiver $receiver): void {
        $this->receiver->add($receiver);
    }

    /**
     * @return ArrayList
     */
    public function getCarbonCopy(): ArrayList {
        return $this->carbonCopy;
    }

    /**
     * @param Receiver $carbonCopy
     */
    public function addCarbonCopy(Receiver $carbonCopy): void {
        $this->carbonCopy->add($carbonCopy);
    }

    /**
     * @return ArrayList
     */
    public function getBlindCarbonCopy(): ArrayList {
        return $this->blindCarbonCopy;
    }

    /**
     * @param Receiver $blindCarbonCopy
     */
    public function addBlindCarbonCopy(Receiver $blindCarbonCopy): void {
        $this->blindCarbonCopy->add($blindCarbonCopy);
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreateTs(): DateTimeInterface {
        return $this->createTs;
    }

    /**
     * @param DateTimeInterface $createTs
     */
    public function setCreateTs(DateTimeInterface $createTs): void {
        $this->createTs = $createTs;
    }

    /**
     * @return DateTimeInterface
     */
    public function getScheduleTs(): DateTimeInterface {
        return $this->scheduleTs;
    }

    /**
     * @param DateTimeInterface $scheduleTs
     */
    public function setScheduleTs(DateTimeInterface $scheduleTs): void {
        $this->scheduleTs = $scheduleTs;
    }

    /**
     * @return ArrayList
     */
    public function getHeaders(): ArrayList {
        return $this->headers;
    }

    /**
     * @param Header $header
     */
    public function addHeader(Header $header): void {
        $this->headers->add($header);
    }

    /**
     * @return string
     */
    public function getBody(): string {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void {
        $this->body = $body;
    }

    /**
     * @return ArrayList
     */
    public function getReplyTo(): ArrayList {
        return $this->replyTo;
    }

    public function addReplyTo(ReplyTo $replyTo): void {
        $this->replyTo->add($replyTo);
    }

    /**
     * @return ArrayList
     */
    public function getAttachment(): ArrayList {
        return $this->attachment;
    }

    /**
     * @param Attachment $attachment
     */
    public function addAttachment(Attachment $attachment): void {
        $this->attachment->add($attachment);
    }

    /**
     * @return string
     */
    public function getSubject(): string {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getAltBody(): string {
        return $this->altBody;
    }

    /**
     * @param string $altBody
     */
    public function setAltBody(string $altBody): void {
        $this->altBody = $altBody;
    }

    public function jsonSerialize(): array {
        return [
            'id'                => $this->getId(),
            'sender'            => $this->getSender(),
            'reply_to'          => $this->getReplyTo()->toArray(),
            'receiver'          => $this->getReceiver()->toArray(),
            'carbon_copy'       => $this->getCarbonCopy()->toArray(),
            'blind_carbon_copy' => $this->getBlindCarbonCopy()->toArray(),
            'attachments'       => $this->getAttachment()->toArray(),
            'create_ts'         => $this->getCreateTs(),
            'schedule_ts'       => $this->getScheduleTs(),
            'headers'           => $this->getHeaders()->toArray(),
            'body'              => $this->getBody(),
            'alt_body'          => $this->getAltBody(),
            'subject'           => $this->getSubject()
        ];
    }

}