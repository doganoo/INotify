<?php
/**
 * Created by PhpStorm.
 * User: doganucar
 * Date: 2019-03-13
 * Time: 22:09
 */

namespace doganoo\INotify\Participant;


interface IParticipant {
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