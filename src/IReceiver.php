<?php

namespace Yang\Notification;

/**
 * Interface IReceiver
 * @package Yang\Notification
 */
interface IReceiver
{
    /**
     * @param string $type
     * @param mixed $data
     * @return void
     */
    public function onNotification($type, $data);
}
