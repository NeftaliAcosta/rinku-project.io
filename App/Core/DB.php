<?php

namespace App\Core;

use App\Core\MySql\MySql;
use App\Libs\Tools;
use PDOException;

/**
 * DB (Database transaction)
 * Class made to process transactions with our DB
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */
class DB
{
    /**
     * Which table are we going to use for transactions
     *
     * @var string
     */
    private string $alias_table = '';

    /**
     * Table identifier to work with
     *
     * @var int
     */
    private int $id;

    public function __construct(string $alias_table, int $id)
    {
        $this->alias_table = $alias_table;
        $this->id = $id;
    }

    /**
     * Get last version of database
     *
     * @return array|bool
     */
    public static function getVersion(): array|bool
    {
        $sql = new MySql();
        $data = $sql->custom("SELECT version, modified_at FROM versions");
        try {
            $version = $data->execute();
        } catch (PDOException) {
            self::init();
            $version = $data->execute();
        }
        return $version['data'];
    }

    /**
     * Create the version control table
     *
     * @return void
     */
    public static function init(): void
    {
        $sql = new MySql();
        $sql->custom("
            CREATE TABLE IF NOT EXISTS 
                versions
            (
                version VARCHAR(255),
                modified_at BIGINT
            )");
        $sql->execute();
    }

    /**
     * Set the current version in the database
     *
     * @param int $version
     * @return void
     */
    public static function setVersion(int $version): void
    {
        $sql = new MySql();
        if ($version < 2) {
            $custom_query = "
                INSERT INTO 
                    versions 
                (
                    version, 
                    modified_at
                ) 
                VALUES 
                (
                  " . $version . ",
                  " . time() . "
                )";
        } else {
            $custom_query = "
                UPDATE 
                    versions
                SET modified_at = " . time() . ",
                    version = " . $version;
        }
        $sql->custom($custom_query);
        $sql->execute();
    }

    /**
     * Set value for a specific column in our database using updateString() method
     *
     * @param string $parameter
     * @param string $value
     * @param array|null $v_wh
     * @return void
     * @throws SystemException
     */
    public function setString(string $parameter, string $value, array $v_wh = null): void
    {
        if ($value != "") {
            // Object to access database
            $o_sql = new MySql();
            $update = $o_sql->update();

            // $v_wh Variable for where clause in the query
            if (empty($v_wh)) {
                $v_wh = [
                    'id = ?' => [
                        'type' => 'int',
                        'value' => Tools::scInt($this->id),
                    ],
                ];
            }

            // Query in data base
            $update->updateString($parameter, Tools::scStr($value))->from($this->alias_table)->where($v_wh)->execute();
        }
    }

    /**
     * Set column value in the database using updateInt() method
     *
     * @param string $parameter
     * @param int $value
     * @param array|null $v_wh
     * @return void
     * @throws SystemException
     */
    public function setInt(string $parameter, int $value, array $v_wh = null): void
    {
        if ($value != 0) {
            $o_sql = new Sql();
            $update = $o_sql->update();

            // $where clause is being defined just here
            if (empty($v_wh)) {
                $v_wh = [
                    'id = ?' => [
                        'type' => 'int',
                        'value' => Tools::scInt($this->id),
                    ],
                ];
            }

            // Set new value in our database table
            $update->updateInt($parameter, Tools::scInt($value))->from($this->alias_table)->where($v_wh)->execute();
        }
    }

    /**
     * * Set column value in the database using updateFloat() method
     *
     * @param string $parameter
     * @param float $value
     * @param array|null $v_wh
     * @return void
     * @throws SystemException
     */
    public function setFloat(string $parameter, float $value, array $v_wh = null): void
    {
        if ($value != 0) {
            $o_sql = new Sql();
            $update = $o_sql->update();


            // $where clause is being defined just here
            if (empty($v_wh)) {
                $v_wh = [
                    'id = ?' => [
                        'type' => 'int',
                        'value' => $this->id,
                    ],
                ];
            }

            // Set new value in our database table
            $update->updatefloat($parameter, Tools::scFloat($value))->from($this->alias_table)->where($v_wh)->execute();
        }
    }

    /**
     * Set status value in the database
     *
     * @param string $parameter
     * @param int $value
     * @param array|null $v_wh
     * @return void
     * @throws SystemException
     */
    public function setStatus(string $parameter, int $value, array $v_wh = null): void
    {
        if ($value >= 0 && $value <= 1) {
            $o_sql = new Sql();
            $update = $o_sql->update();

            // $where clause is being defined just here
            if (empty($v_wh)) {
                $v_wh = [
                    'id = ?' => [
                        'type' => 'int',
                        'value' => Tools::scInt($this->id),
                    ],
                ];
            }

            // Set new value in our database table
            $update->updateInt($parameter, Tools::scInt($value))->from($this->alias_table)->where($v_wh)->execute();
        }
    }
}
