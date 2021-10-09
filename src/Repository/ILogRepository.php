<?php
declare(strict_types=1);

namespace doganoo\INotify\Repository;

use doganoo\INotify\Entity\Log\Log;
use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayList\ArrayList;

interface ILogRepository {

    public function getAll(): ArrayList;

    public function store(Log $log): Log;

    public function storeAll(ArrayList $queue): ArrayList;

}