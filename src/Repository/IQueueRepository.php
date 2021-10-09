<?php
declare(strict_types=1);

namespace doganoo\INotify\Repository;

use doganoo\INotify\Entity\Queue\Item;
use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayList\ArrayList;

interface IQueueRepository {

    public function getAll(): ArrayList;

    public function store(Item $item): Item;

    public function storeAll(ArrayList $queue): ArrayList;

}