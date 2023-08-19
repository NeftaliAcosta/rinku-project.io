<?php

/**
 * Restore initial database for recovery
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */

use App\Core\Cli;
use App\Core\Environment;
use App\Core\MySql\MySql;
use App\Core\SystemException;
use App\Enums\ConsoleBackgroundColors;
use App\Enums\ConsoleForegroundColors;

/**
 * Load composer
 */
require __DIR__.'/../vendor/autoload.php';

/**
 * Load environment to work
 */
Environment::load();

/**
 * Enable error reporting in dev environment
 */
if (Environment::isDev()) {
    // Show errors
    error_reporting(-1);
    error_reporting(E_ALL);
    ini_set('error_reporting', E_ALL);
}

Cli::e(
    "++++++++++ Checking exists file initial recover ++++++++++",
    ConsoleForegroundColors::Magenta,
    ConsoleBackgroundColors::Yellow
);

// Database connection
$db_name = $_ENV["DB_NAME"];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];
$db_host = $_ENV['DB_HOST'];
$dsn = "mysql:host=" . $db_host . ";charset=utf8";

// Check if the database exists
Cli::e(
    "-> Check if the database exists.",
    ConsoleForegroundColors::Magenta,
    ConsoleBackgroundColors::Black
);
try {
    $instance = new PDO($dsn, $db_user, $db_pass, [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
        PDO::ATTR_PERSISTENT => true
    ]);

    $instance->exec("
            CREATE DATABASE IF NOT EXISTS `" . $db_name . "`
        ");
} catch (PDOException) {
    Cli::e(
        "-> Database can not create.",
        ConsoleForegroundColors::Magenta,
        ConsoleBackgroundColors::Black
    );
    die();
}

// Process of recovery
try {
    // Object to access DB
    $o_mysql = new MySql();

    // Cli message
    Cli::e(
        "-> Deleting current database.",
        ConsoleForegroundColors::Magenta,
        ConsoleBackgroundColors::Black
    );

    // Step 1. Drop current database
    $o_mysql->custom("DROP database " . $db_name)->execute();

    // Cli message
    Cli::e(
        "-> Restore database Initial, please waiting.",
        ConsoleForegroundColors::Magenta,
        ConsoleBackgroundColors::Black
    );

    // Step 2. Create empty database
    $o_mysql->custom("CREATE SCHEMA `" . $db_name . "`")->execute();

    // Cli message
    Cli::e(
        "-> Processing inits files.",
        ConsoleForegroundColors::Yellow,
        ConsoleBackgroundColors::Black
    );

    // Processing existing inits
    include_once('init.php');

} catch (SystemException $e) {
    // Show error in case of exception thrown
    Cli::e(
        "There was an error: " . $e->getMessage(),
        ConsoleForegroundColors::Yellow,
        ConsoleBackgroundColors::Red
    );
}
