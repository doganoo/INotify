<?php


namespace doganoo\INotify;


interface IUser {
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getDisplayname(): string;

    /**
     * @return string
     */
    public function getEmail(): string;

}