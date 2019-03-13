<?php
/**
 * Created by PhpStorm.
 * User: doganucar
 * Date: 2019-03-13
 * Time: 23:29
 */

namespace doganoo\INotify\Notification\Mail;


class PlainMail extends Mail
{
    /**
     * PlainMailNotifier constructor.
     */
    public function __construct() {
        parent::__construct();
        parent::setIsHTML(false);
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void {
        $message = \strip_tags($message);
        parent::setMessage($message);
    }

}