<?php
declare(strict_types=1);

namespace doganoo\INotify\Entity\Header;

use doganoo\INotify\Entity\IJsonObject;

class Header implements IJsonObject {

    private string $name;
    private string $value;

    public function __construct(string $name, string $value) {
        $this->setName($name);
        $this->setValue($value);
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

    /**
     * @return string
     */
    public function getValue(): string {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void {
        $this->value = $value;
    }

    public function jsonSerialize(): array {
        return [
            'name'  => $this->getName(),
            'value' => $this->getValue()
        ];
    }

}