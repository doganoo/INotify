<?php
declare(strict_types=1);

namespace doganoo\INotify\Entity\Attachment;

use doganoo\INotify\Entity\IJsonObject;

class Attachment implements IJsonObject {

    private string $path;
    private string $name;

    public function __construct(string $path, string $name) {
        $this->setPath($path);
        $this->setName($name);
    }

    /**
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void {
        $this->path = $path;
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
            'path' => $this->getPath(),
            'name' => $this->getName()
        ];
    }

}