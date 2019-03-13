<?php

namespace doganoo\PINotify;

use doganoo\INotify\INotifier;
use doganoo\INotify\IReceiver;
use doganoo\INotify\IRoute;
use doganoo\INotify\IUser;
use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayLists\ArrayList;

class AbstractRoute implements IRoute {
    private $notifierList = null;
    private $receiverList = null;
    private $owner = null;
    private $routable = true;

    public function __construct() {
        $this->notifierList = new ArrayList();
        $this->receiverList = new ArrayList();
    }

    public function getOwner(): IUser {
        return $this->owner;
    }

    public function setOwner(IUser $owner): void {
        $this->owner = $owner;
    }

    public function addNotifier(INotifier $notifier) {
        $this->notifierList->add($notifier);
    }

    public function addReceiver(IReceiver $receiver) {
        $this->receiverList = $receiver;
    }


    public function getNotifier(): ArrayList {
        return $this->notifierList;
    }

    public function getReceiver(): ArrayList {
        return $this->receiverList;
    }

    public function isRoutable(): bool {
        return $this->routable;
    }
}