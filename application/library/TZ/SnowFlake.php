<?php

/**
 * Twitter的分布式自增ID算法
 */
class TZ_SnowFlake
{
    //开始时间截 (2018-01-01 01:01:01)
    const EPOCH = 1514739661000;
    const max12bit = 4095;
    const max41bit = 1099511627775;

    static $machineId = null;

    public static function machineId($mId = 0)
    {
        self::$machineId = $mId;
    }

    public static function getId()
    {
        /*
        * Time - 42 bits
        */
        $time = floor(microtime(true) * 1000);
        /*
        * Substract custom epoch from current time
        */
        $time -= self::EPOCH;
        /*
        * Create a base and add time to it
        */
        $base = decbin(self::max41bit + $time);
        /*
        * Configured machine id - 10 bits - up to 1024 machines
        */
        if (!self::$machineId) {
            $machineid = self::$machineId;
        } else {
            $machineid = str_pad(decbin(self::$machineId), 10, "0", STR_PAD_LEFT);
        }
        /*
        * sequence number - 12 bits - up to 4096 random numbers per machine
        */
        $random = str_pad(decbin(mt_rand(0, self::max12bit)), 12, "0", STR_PAD_LEFT);

        /*
        * Pack
        */
        $base = $base . $machineid . $random;
        /*
        * Return unique time id no
        */
        return bindec($base);
    }

    public static function getTimeFromId($id)
    {
        /*
        * Return time
        */
        return bindec(substr(decbin($id), 0, 41)) - self::max41bit + self::EPOCH;
    }
}
