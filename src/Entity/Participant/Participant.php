<?php
declare(strict_types=1);

namespace doganoo\INotify\Entity\Participant;

use doganoo\INotify\Entity\IJsonObject;

abstract class Participant implements IJsonObject {

    private string $address;
    private string $name;

    public function __construct(string $address, string $name) {
        $this->setName($name);
        $this->setAddress($address);
    }

    /**
     * @return string
     */
    public function getAddress(): string {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    public function jsonSerialize(): array {
        return [
            'address' => $this->getAddress(),
            'name'    => $this->getName()
        ];
    }

}