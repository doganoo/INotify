<?php
declare(strict_types=1);

namespace doganoo\INotify\Factory\Handler;

use doganoo\INotify\Handler\QueueHandler;
use doganoo\INotify\Repository\IQueueRepository;
use doganoo\INotify\Service\LogService;
use doganoo\INotify\Service\MailService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class QueueHandlerFactory implements FactoryInterface {

    public function __invoke(
        ContainerInterface $container,
                           $requestedName,
        ?array             $options = null
    ): QueueHandler {
        return new QueueHandler(
            $container->get(IQueueRepository::class),
            $container->get(MailService::class),
            $container->get(LogService::class)
        );
    }

}