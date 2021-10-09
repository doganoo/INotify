<?php
declare(strict_types=1);

namespace doganoo\INotify\Factory\Service;

use doganoo\INotify\Repository\ILogRepository;
use doganoo\INotify\Service\LogService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class LogServiceFactory implements FactoryInterface {

    public function __invoke(
        ContainerInterface $container,
                           $requestedName,
        ?array             $options = null
    ): LogService {
        return new LogService(
            $container->get(ILogRepository::class)
        );
    }

}