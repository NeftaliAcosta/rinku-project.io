<?php

// Add table `rinku_monthly_movements`

use App\Core\Cli;
use App\Core\Container\Container;
use App\Core\MySql\MySql;
use App\Enums\ConsoleForegroundColors;

/** @var MySql $o_mysql */

// Set table name from Container
$table_monthly_movements = Container::getTable('monthly_movements');
$table_employees = Container::getTable('employees');

// Print message
Cli::e(
    "Creating Table `{$table_monthly_movements}`",
    ConsoleForegroundColors::Green
);

// Execute script
$o_mysql->custom("
    CREATE TABLE IF NOT EXISTS `{$table_monthly_movements}` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `employee_id` INT NOT NULL,
        `month` INT NOT NULL,
        `year` YEAR NOT NULL,
        `deliveries` INT NOT NULL,
        `creation_date` DATETIME NOT NULL,
        PRIMARY KEY (`id`),
        KEY `employee_id` (`employee_id`),
        CONSTRAINT `FK_rinku_monthly_movements_rinku_employees` FOREIGN KEY (`employee_id`) REFERENCES `{$table_employees}` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
")->execute();
