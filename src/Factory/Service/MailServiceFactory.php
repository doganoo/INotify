<?php
declare(strict_types=1);

namespace doganoo\INotify\Factory\Service;

use doganoo\INotify\Service\MailService;
use Interop\Container\ContainerInterface;
use Laminas\Config\Config;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Log\LoggerInterface;

class MailServiceFactory implements FactoryInterface {

    public function __invoke(
        ContainerInterface $container,
                           $requestedName,
        ?array             $options = null
    ): MailService {
        return new MailService(
            $container->get(Config::class),
            $container->get(LoggerInterface::class),
        );
    }

}