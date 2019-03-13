<?php
/**
 * Created by PhpStorm.
 * User: doganucar
 * Date: 2019-03-13
 * Time: 22:45
 */

namespace doganoo\INotify\Queue\Simple;


use doganoo\INotify\Notification\INotifier;
use doganoo\INotify\Notification\Mail\Mail;
use doganoo\INotify\Object\ReceiverList;
use doganoo\INotify\Participant\IReceiver;
use doganoo\INotify\Queue\IConfig;

class SimpleConfig implements IConfig {

    private $environment = IConfig::ENVIRONMENT_DEV;
    /** @var null|ReceiverList $receiver */
    private $receiver = null;

    public function __construct()
    {
        $this->receiver = new ReceiverList();
    }

    public function setEnvironment(int $environment):void{
        $this->environment = $environment;
    }
    public function getEnvironment(): int
    {
     return $this->environment;
    }

    public function getDefaultNotifier(): INotifier
    {
        return new Mail();
    }

    public function addDefaultReceiver(IReceiver $receiver):void {
        $this->receiver->add($receiver);

    }

    public function getDefaultReceiver(): ?ReceiverList
    {
        return $this->receiver;
    }
}