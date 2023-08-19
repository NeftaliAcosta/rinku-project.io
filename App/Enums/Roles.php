<?php

namespace App\Enums;

use App\Core\SystemException;
use App\Core\ToolsEnums;

/**
 * Roles Enum
 * System Roles Catalog
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */
enum Roles: int
{
    use ToolsEnums;
    case DRIVER = 1;
    case INCHARGE = 2;
    case ASSISTANT = 3;

    /**
     * Return pretty value of an enum
     *
     * @param int $value
     * @return string
     * @throws SystemException
     */
    public static function pretty(int $value): string
    {
        return match ($value) {
            Roles::DRIVER->value => "Chofer",
            Roles::INCHARGE->value => "Encargado",
            Roles::ASSISTANT->value => "Auxiliar",
            default => throw new SystemException("Enum value not found."),
        };
    }
}
