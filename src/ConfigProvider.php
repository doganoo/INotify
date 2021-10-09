<?php
declare(strict_types=1);

namespace doganoo\INotify;

use doganoo\INotify\Factory\Handler\QueueHandlerFactory;
use doganoo\INotify\Factory\Service\LogServiceFactory;
use doganoo\INotify\Factory\Service\MailServiceFactory;
use doganoo\INotify\Factory\Service\QueueServiceFactory;
use doganoo\INotify\Handler\QueueHandler;
use doganoo\INotify\Service\LogService;
use doganoo\INotify\Service\MailService;
use doganoo\INotify\Service\QueueService;

final class ConfigProvider {

    public const MAILER_EXCEPTIONS_ENABLED = 'enabled.exceptions.mailer.inotify';
    public const MAILER_DEBUG_MODE         = 'mode.debug.mailer.inotify';
    public const MAILER_SMTP_MODE          = 'mode.smtp.mailer.inotify';
    public const MAILER_SMTP_HOST          = 'host.smtp.mailer.inotify';
    public const MAILER_SMTP_USERNAME      = 'username.smtp.mailer.inotify';
    public const MAILER_SMTP_PASSWORD      = 'password.smtp.mailer.inotify';
    public const MAILER_SMTP_PORT          = 'port.smtp.mailer.inotify';
    public const MAILER_HTML_MODE          = 'mode.html.mailer.inotify';
    public const MAILER_SENDING_ENABLED    = 'enabled.sending.mailer.inotify';

    public function __invoke(): array {
        return [
            'dependencies' => [
                [
                    'factories' => [
                        // Handler
                        QueueHandler::class => QueueHandlerFactory::class,

                        // Service
                        LogService::class   => LogServiceFactory::class,
                        MailService::class  => MailServiceFactory::class,
                        QueueService::class => QueueServiceFactory::class,
                    ]
                ]
            ]
        ];
    }

}