<?php

namespace App\Core\Container;

use App\Core\Container\Exception\TableNotFoundException;
use App\Core\SystemException;

/**
 * Container
 * Saves the relationship between the original database and the model alias
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */
class Container{

    /**
     * Alias tables dictionary
     *
     * @var array $tables
     */
    public static array $tables = array(
        'users' => 'rinku_users',
        'employees' => 'rinku_employees',
        'monthly_movements' => 'rinku_monthly_movements',

    );

    /**
     * Gets the actual name of the table in the database
     *
     * @param string $table
     * @return string
     */
    public static function getTable(string $table): string
    {
        try {
            if (array_key_exists($table, self::$tables)) {
                return self::$tables[$table];
            }else{
                throw new TableNotFoundException('The alias table does not exist.');
            }
        } catch (SystemException $e) {
            echo $e->errorMessage();
        }
    }

}
