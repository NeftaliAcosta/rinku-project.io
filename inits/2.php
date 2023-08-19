<?php

// Add table `rinku_employees`

use App\Core\Cli;
use App\Core\Container\Container;
use App\Core\MySql\MySql;
use App\Enums\ConsoleForegroundColors;

/** @var MySql $o_mysql */

// Set table name from Container
$table = Container::getTable('employees');

// Print message
Cli::e(
    "Creating Table `{$table}`",
    ConsoleForegroundColors::Green
);

// Execute script
$o_mysql->custom("
    CREATE TABLE IF NOT EXISTS `{$table}` (
        `id` int NOT NULL AUTO_INCREMENT,
        `code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
        `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
        `enum_rol` int NOT NULL,
        `creation_date` time NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
")->execute();
