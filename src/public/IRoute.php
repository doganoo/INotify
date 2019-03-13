<?php

namespace doganoo\INotify;

use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayLists\ArrayList;

interface IRoute {

    public function getNotifier(): ArrayList;

    public function getReceiver(): ArrayList;

    public function getOwner(): IUser;

    public function isRoutable(): bool;

}