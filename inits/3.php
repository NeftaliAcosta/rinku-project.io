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
        `deliveries` INT NOT NULL,
        `extra_salary` INT NOT NULl,
        `taxes` INT NOT NULL,
        `grocery_vouchers` decimal(10,2) NOT NULL,
        `month` INT NOT NULL,
        `creation_date` DATETIME NOT NULL,
        PRIMARY KEY (`id`),
        KEY `employee_id` (`employee_id`),
        CONSTRAINT `FK_rinku_monthly_movements_rinku_employees` FOREIGN KEY (`employee_id`) REFERENCES `{$table_employees}` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
")->execute();


// Print message
Cli::e(
    "Creating Stored Procedure `sp_MonthlyMovementCreate` in table:`{$table_monthly_movements}`",
    ConsoleForegroundColors::Green
);

// Execute script
$o_mysql->custom("
    CREATE PROCEDURE `sp_MonthlyMovementCreate`(
        IN `emp_id` INT,
        IN `emp_deliveries` INT,
        IN `num_month` INT
    )
    LANGUAGE SQL
    NOT DETERMINISTIC
    CONTAINS SQL
    SQL SECURITY DEFINER
    COMMENT 'Add a monthly record for an employee'
    BEGIN
        DECLARE local_emp_id INT;
        DECLARE local_emp_enum_rol INT;
        DECLARE local_emp_base_salary INT;
        DECLARE local_extra_salary INT;
        DECLARE local_bonus_extra_hour INT;
        DECLARE local_taxes INT DEFAULT 9;
        DECLARE local_grocery_vouchers DECIMAL(10, 2);
        
        -- Gets employee information based on emp_id parameter
        SELECT id, enum_rol, base_salary INTO local_emp_id, local_emp_enum_rol, local_emp_base_salary
        FROM {$table_employees}
        WHERE id = emp_id;
        
        -- Additional salary according to deliveries
        SET local_extra_salary = emp_deliveries * 5;
        
        -- Additional salary according to role
        IF local_emp_enum_rol = 1 THEN
            SET local_bonus_extra_hour = (8 * 6 * 4) * 10;
            SET local_extra_salary = local_extra_salary + local_bonus_extra_hour;
        ELSEIF local_emp_enum_rol = 2 THEN
            SET local_bonus_extra_hour = (8 * 6 * 4) * 5;
            SET local_extra_salary = local_extra_salary + local_bonus_extra_hour;
        END IF;
        
        -- Calculate taxes
        IF local_emp_base_salary + local_extra_salary > 10000 THEN
            SET local_taxes = local_taxes + 3;
        END IF;
        
        -- Calculate grocery vouchers
        SET local_grocery_vouchers = (local_emp_base_salary + local_extra_salary) * 0.04;
        
        INSERT INTO {$table_monthly_movements} (employee_id, deliveries, extra_salary, taxes, grocery_vouchers, creation_date, `month`)
        VALUES (local_emp_id, emp_deliveries, local_extra_salary, local_taxes, local_grocery_vouchers, NOW(), num_month);
    END
")->execute();


// Print message
Cli::e(
    "Creating Stored Procedure `sp_MonthlyMovementUpdate` in table:`{$table_monthly_movements}`",
    ConsoleForegroundColors::Green
);

// Execute script
$o_mysql->custom("
CREATE PROCEDURE `sp_MonthlyMovementUpdate`(
    IN `monthly_movement_id` INT,
    IN `emp_deliveries` INT,
    IN `num_month` INT
)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT 'Update a monthly record of an employee'
BEGIN
    DECLARE local_emp_id INT;
    DECLARE local_emp_enum_rol INT;
    DECLARE local_emp_base_salary INT;
    DECLARE local_extra_salary INT;
    DECLARE local_bonus_extra_hour INT;
    DECLARE local_taxes INT DEFAULT 9;
    DECLARE local_grocery_vouchers DECIMAL(10, 2);

    -- Get employee_id from monthly movement table
    SELECT `employee_id` INTO local_emp_id
    FROM {$table_monthly_movements}
    WHERE id = monthly_movement_id;

    -- Gets employee information based on emp_id parameter
    SELECT `id`, `enum_rol`, `base_salary` INTO local_emp_id, local_emp_enum_rol, local_emp_base_salary
    FROM {$table_employees}
    WHERE `id` = local_emp_id;

    -- Additional salary according to deliveries
    SET local_extra_salary = emp_deliveries * 5;

    -- Additional salary according to role
    IF local_emp_enum_rol = 1 THEN
        SET local_bonus_extra_hour = (8 * 6 * 4) * 10;
        SET local_extra_salary = local_extra_salary + local_bonus_extra_hour;
    ELSEIF local_emp_enum_rol = 2 THEN
        SET local_bonus_extra_hour = (8 * 6 * 4) * 5;
        SET local_extra_salary = local_extra_salary + local_bonus_extra_hour;
    END IF;

    -- Calculate taxes
    IF local_emp_base_salary + local_extra_salary > 10000 THEN
        SET local_taxes = local_taxes + 3;
    END IF;

    -- Calculate grocery vouchers
    SET local_grocery_vouchers = (local_emp_base_salary + local_extra_salary) * 0.04;

    UPDATE {$table_monthly_movements} SET 
    `deliveries` = emp_deliveries,
    `extra_salary` = local_extra_salary,
    `taxes` = local_taxes,
    `grocery_vouchers` = local_grocery_vouchers,
    `creation_date` = NOW(),
    `month` = num_month
    WHERE `id` = monthly_movement_id;
END
")->execute();

// Print message
Cli::e(
    "Creating Stored Procedure `sp_MonthlyMovementView` in table:`{$table_monthly_movements}`",
    ConsoleForegroundColors::Green
);

// Execute script
$o_mysql->custom("
CREATE PROCEDURE `sp_MonthlyMovementView`(
    IN `monthly_movement_id` INT
)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT 'View information by monthly_movement_id'
BEGIN
    SELECT `id`, `employee_id`, `deliveries`, `extra_salary`, `taxes`, `grocery_vouchers`, `creation_date`, `month`
    FROM {$table_monthly_movements}
    WHERE `id` = monthly_movement_id;
END
")->execute();

// Print message
Cli::e(
    "Creating Stored Procedure `sp_MonthlyMovementDelete` in table:`{$table_monthly_movements}`",
    ConsoleForegroundColors::Green
);

// Execute script
$o_mysql->custom("
CREATE PROCEDURE `sp_MonthlyMovementDelete`(
    IN `monthly_movement_id` INT
)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT 'Delete an existing row'
BEGIN
    -- Deleting row from monthly movements table
    DELETE FROM `{$table_monthly_movements}` WHERE `id` = monthly_movement_id;
END
")->execute();
