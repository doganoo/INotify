<?php
declare(strict_types=1);

namespace doganoo\INotify\Entity\Log;

use DateTimeInterface;
use doganoo\INotify\Entity\IJsonObject;
use doganoo\INotify\Entity\Queue\Item;

class Log implements IJsonObject {

    private Item              $item;
    private DateTimeInterface $createTs;
    private DateTimeInterface $sendTs;
    private DateTimeInterface $deleteTs;

    /**
     * @return Item
     */
    public function getItem(): Item {
        return $this->item;
    }

    /**
     * @param Item $item
     */
    public function setItem(Item $item): void {
        $this->item = $item;
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
    public function getSendTs(): DateTimeInterface {
        return $this->sendTs;
    }

    /**
     * @param DateTimeInterface $sendTs
     */
    public function setSendTs(DateTimeInterface $sendTs): void {
        $this->sendTs = $sendTs;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDeleteTs(): DateTimeInterface {
        return $this->deleteTs;
    }

    /**
     * @param DateTimeInterface $deleteTs
     */
    public function setDeleteTs(DateTimeInterface $deleteTs): void {
        $this->deleteTs = $deleteTs;
    }

    public function jsonSerialize(): array {
        return [
            'item'      => $this->getItem(),
            'create_ts' => $this->getCreateTs(),
            'send_ts'   => $this->getSendTs(),
            'delete_ts' => $this->getDeleteTs()
        ];
    }

}