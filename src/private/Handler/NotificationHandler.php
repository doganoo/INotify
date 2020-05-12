<?php
declare(strict_types=1);
/**
 * MIT License
 *
 * Copyright (c) 2018 Dogan Ucar, <dogan@dogan-ucar.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace doganoo\IN\Handler;

use doganoo\IN\Participant\NotificationList;
use doganoo\INotify\Handler\INotificationHandler;
use doganoo\INotify\Notification\INotification;
use doganoo\INotify\Notification\INotificationList;
use doganoo\INotify\Notification\Type\IType;
use doganoo\INotify\Service\Mapper\IMapper;
use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayLists\ArrayList;
use doganoo\SimpleRBAC\Handler\PermissionHandler;

/**
 * Class NotificationHandler
 *
 * @package doganoo\IN\Handler
 * @author  Dogan Ucar <dogan@dogan-ucar.de>
 */
class NotificationHandler implements INotificationHandler {

    /** @var INotificationList|ArrayList */
    private $notificationList;
    /** @var IMapper */
    private $mapper;
    /** @var PermissionHandler */
    private $permissionHandler;

    public function __construct(
        IMapper $mapper
        , PermissionHandler $permissionHandler
    ) {
        $this->mapper            = $mapper;
        $this->permissionHandler = $permissionHandler;
    }

    public function addNotification(INotification $notification): void {
        $this->notificationList->add($notification);
    }

    public function setNotifications(NotificationList $notificationList): void {
        $this->notificationList = $notificationList;
    }

    public function notify(): bool {
        $notified = false;
        /** @var INotification $notification */
        foreach ($this->getNotifications() as $notification) {
            if (true === $notification->isExecuted()) continue;
            /** @var IType $type */
            foreach ($notification->getTypes() as $type) {
                if (false === $this->permissionHandler->hasPermission($type->getPermission())) continue;
                $applicant = $this->mapper->query($type);
                $applicant->notify($notification);
            }

        }
        return $notified;
    }

    public function getNotifications(): INotificationList {
        return $this->notificationList;
    }

}
