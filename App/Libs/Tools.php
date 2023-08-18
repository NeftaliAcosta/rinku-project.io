<?php

namespace App\Libs;

/**
 * Tools
 * Contains tools used by the system
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */
class Tools
{
    /**
     * Scape a string before insert in database
     *
     * @param string|null $string $string
     * @return string
     */
    public static function scStr(string|null $string): string
    {
        $string = is_null($string) ? '' : $string;
        $string = trim($string);
        return addslashes($string);
    }

    /**
     * Scape an int before insert in database
     *
     * @param int $int
     * @return int
     */
    public static function scInt(mixed $int): int
    {
        return (int)$int;
    }

    /**
     * Scape a float before insert in database
     *
     * @param mixed $float
     * @return float
     */
    public static function scFloat(mixed $float): float
    {
        return (float)$float;
    }
}
