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
     * @var array $tablas
     */
    public array $tablas = array(
        'rinku_users' => 'users',

    );

    /**
     * Gets the actual name of the table in the database
     *
     * @param string $tabla
     * @return string
     */
    public function getTable(string $tabla): string
    {
        try {
            if (array_key_exists($tabla, $this->tablas)) {
                return $this->tablas[$tabla];
            }else{
                throw new TableNotFoundException('The alias table does not exist.');
            }
        } catch (SystemException $e) {
            echo $e->errorMessage();
        }
    }

}
