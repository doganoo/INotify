<?php
/**
 * Created by PhpStorm.
 * User: doganucar
 * Date: 2019-03-13
 * Time: 22:34
 */

namespace doganoo\INotify\Object;

use doganoo\INotify\Participant\IReceiver;
use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayLists\ArrayList;

class ReceiverList extends ArrayList
{
    public function add($item): bool
    {
        if ($item instanceof IReceiver){
            return parent::add($item);
        }
    }

}