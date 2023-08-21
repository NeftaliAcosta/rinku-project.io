<?php

namespace App\Libs;

use App\Core\SystemException;

/**
 * Tools
 * Contains tools used by the system
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */
class Tools extends Random
{
    public static function months(): array
    {
        return array (
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        );
    }

    /**
     * Convert num month to name month
     *
     * @throws SystemException
     */
    public static function getMonthName(int $month): string
    {
        $months = self::months();

        // Check if num month exist
        if (array_key_exists($month, $months)) {
            return $months[$month];
        } else {
            throw new SystemException("Month not valid.");
        }
    }

    /**
     * Get current month
     *
     * @return int
     */
    public static function getCurrentMonth(): int
    {
        return date('n');
    }

}
