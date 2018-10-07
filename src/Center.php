<?php

namespace Yang\Notification;

/**
 * Class Center
 * @package Yang\Notification
 */
final class Center
{
    const ALL = '*';

    /**
     * @var IReceiver[][]
     */
    protected static $receivers = array(self::ALL => array());

    /**
     * @param string $type
     * @param IReceiver $receiver
     */
    public static function register($type, IReceiver $receiver)
    {
        self::$receivers[$type][get_class($receiver)] = $receiver;
    }

    /**
     * @param string $type
     * @param IReceiver $receiver
     */
    public static function unregister($type, IReceiver $receiver)
    {
        unset(self::$receivers[$type][get_class($receiver)]);
    }

    /**
     * @param string $type
     * @param mixed $data
     */
    public static function occur($type, $data = null)
    {
        if (!isset(self::$receivers[$type])) {
            return;
        }

        foreach (self::$receivers[$type] as $receiver) {
            $receiver->onNotification($type, $data);
        }

        foreach (self::$receivers[self::ALL] as $receiver) {
            $receiver->onNotification($type, $data);
        }
    }
}
