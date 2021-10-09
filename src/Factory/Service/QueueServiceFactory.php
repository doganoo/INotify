<?php
declare(strict_types=1);

namespace doganoo\INotify\Factory\Service;

use doganoo\INotify\Service\QueueService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class QueueServiceFactory implements FactoryInterface {

    public function __invoke(
        ContainerInterface $container,
                           $requestedName,
        ?array             $options = null
    ): QueueService {
        return new QueueService();
    }

}