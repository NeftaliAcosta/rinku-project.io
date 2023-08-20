<?php

// Add table `rinku_employees`

use App\Core\Cli;
use App\Core\Container\Container;
use App\Core\MySql\MySql;
use App\Enums\ConsoleForegroundColors;

/** @var MySql $o_mysql */

// Set table name from Container
$table_employees = Container::getTable('employees');
$table_monthly_movements = Container::getTable('monthly_movements');

// Print message
Cli::e(
    "Creating Table `{$table_employees}`",
    ConsoleForegroundColors::Green
);

// Execute script
$o_mysql->custom("
    CREATE TABLE IF NOT EXISTS `{$table_employees}` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `code` VARCHAR(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
        `name` VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
        `enum_rol` INT NOT NULL,
        `base_salary` INT DEFAULT '5760',
        `creation_date` DATETIME NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
")->execute();

// Print message
Cli::e(
    "Creating Stored Procedure `sp_EmployeeCreate` in table:`{$table_employees}`",
    ConsoleForegroundColors::Green
);

// Execute script
$o_mysql->custom("
    CREATE PROCEDURE `sp_EmployeeCreate`(
        IN `emp_code` VARCHAR(5),
        IN `emp_name` VARCHAR(150),
        IN `emp_enum_rol` INT
    )
    LANGUAGE SQL
    NOT DETERMINISTIC
    CONTAINS SQL
    SQL SECURITY DEFINER
    COMMENT 'Add a new employee'
    BEGIN
        INSERT INTO {$table_employees} (`code`, `name`, `enum_rol`, `creation_date`)
        VALUES (emp_code, emp_name, emp_enum_rol, NOW());
    END
")->execute();

// Print message
Cli::e(
    "Creating Stored Procedure `sp_EmployeeUpdate` in table:`{$table_employees}`",
    ConsoleForegroundColors::Green
);

// Execute script
$o_mysql->custom("
    CREATE PROCEDURE `sp_EmployeeUpdate`(
        IN `emp_id` INT,
        IN `emp_code` VARCHAR(5),
        IN `emp_name` VARCHAR(150),
        IN `emp_enum_rol` INT
    )
    LANGUAGE SQL
    NOT DETERMINISTIC
    CONTAINS SQL
    SQL SECURITY DEFINER
    COMMENT 'Update an existing row'
    BEGIN
    UPDATE {$table_employees}
        SET
            `code` = emp_code,
            `name` = emp_name,
            `enum_rol` = emp_enum_rol
        WHERE
            `id` = emp_id;
    END
")->execute();

// Print message
Cli::e(
    "Creating Stored Procedure `sp_EmployeeView` in table:`{$table_employees}`",
    ConsoleForegroundColors::Green
);

// Execute script
$o_mysql->custom("
CREATE PROCEDURE `sp_EmployeeView`(
    IN `emp_id` INT
)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT 'View information by employee_id'
BEGIN
    SELECT `id`, `code`, `name`, `enum_rol`, `base_salary`, `creation_date`
    FROM `{$table_employees}`
    WHERE `id` = emp_id;
END
")->execute();


// Print message
Cli::e(
    "Creating Stored Procedure `sp_EmployeeDelete` in table:`{$table_employees}`",
    ConsoleForegroundColors::Green
);


// Execute script
$o_mysql->custom("
CREATE PROCEDURE `sp_EmployeeDelete`(
    IN `emp_id` INT
)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT 'Delete an existing row'
BEGIN
    -- Deleting row from monthly movements table
    DELETE FROM `{$table_monthly_movements}` WHERE `employee_id` = emp_id;
    
    -- Deleting row from employees table
    DELETE FROM `{$table_employees}` WHERE `id` = emp_id;
END
")->execute();
