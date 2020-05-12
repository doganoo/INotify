<?php
declare(strict_types=1);

namespace doganoo\INotify\Service\Log;

interface ILoggerService {

    public const DEBUG = 12345;

    public function log(string $key, string $value, int $level): void;

}
