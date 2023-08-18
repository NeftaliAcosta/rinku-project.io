<?php

namespace App\Core;

use \PDO;
use \PDOException;

/**
 * Connexion Class
 * Database connector
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */
class Connexion{
    /**
     * Database username
     *
     * @access private
     * @var string
     */
    private $db_user;

    /**
     * Database name
     *
     * @access private
     * @var string
     */
    private $db_name;

    /**
     * Database password
     *
     * @access private
     * @var string
     */
    private $db_password;

    /**
    * Database host name
    *
    * @access private
    * @var string
    */
    private $db_host;

    public function __construct(
        string $usuario,
        string $database,
        string $password,
        string $host
    ){
    $this->db_user = $usuario;
    $this->db_name = $database;
    $this->db_password = $password;
    $this->db_host = $host;
    }

    /**
     * @return PDO|false
     */
    public function connect() : PDO|false
    {
        $dsn = "mysql:host=".$this->db_host.";dbname=".$this->db_name.";charset=utf8";

        try {
            $mbd = new PDO($dsn, $this->db_user, $this->db_password, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                    PDO::ATTR_PERSISTENT => true
                )
            );
            $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $mbd->exec('SET NAMES "utf8"');
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }

        return $mbd;
    }

}
