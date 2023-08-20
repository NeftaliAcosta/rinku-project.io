<?php

namespace App\Core;

/**
 * ToolsEnums
 * Add additional methods for enums
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */
trait ToolsEnums
{
    /**
     * Get a value of enum
     *
     * @param string $value
     * @return int
     */
    public static function get(string $value): int
    {
        foreach (self::cases() as $case) {
            if ($value == $case->name) {
                return $case->value;
            }
        }
        return 0;
    }

    /**
     * Get pretty values in array associative
     *
     * @return array
     */
    public static function getPrettyRolesArray(): array
    {
        $prettyValues = [];

        foreach (static::cases() as $case) {
            $prettyValues[$case->value] = static::pretty($case->value);
        }

        return $prettyValues;
    }

    /**
     * Get an array with names and values of enum
     *
     * @return array
     */
    public static function toArray(): array
    {
        return array_combine(self::names(), self::values());
    }

    /**
     * Get only names of enum
     *
     * @return array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Get only values of enum
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
