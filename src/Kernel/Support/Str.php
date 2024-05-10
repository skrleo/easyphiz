<?php
/*
 * @author: Rio
 * @Date: 2024-05-08 14:51:34
 */


namespace PhizPay\Kernel\Support;


class Str
{
    /**
     * Generates a random string of the specified length.
     *
     * @param int $length The length of the random string. Default is 16.
     * @return string The randomly generated string.
     */
    public static function random($length = 16)
    {
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    /**
     * Generates a random integer string of the specified length.
     *
     * @param int $length The length of the random integer string. Default is 16.
     * @return string The randomly generated integer string.
     */
    public static function random_int($length = 16)
    {
        $pool = '0123456789';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}