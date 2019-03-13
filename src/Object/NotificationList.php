<?php
/**
 * Created by PhpStorm.
 * User: doganucar
 * Date: 2019-03-13
 * Time: 22:39
 */

namespace doganoo\INotify\Object;


use doganoo\INotify\Notification\INotifier;
use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayLists\ArrayList;

class NotificationList extends ArrayList
{

    public function add($item): bool
    {
        if ($item instanceof INotifier){
            return parent::add($item);
        }
    }

}