<?php

namespace App\Models\Employees;

use App\Core\MySql\MySql;
use App\Models\Employees\Exceptions\EmployeeCannotBeCreatedException;
use App\Models\Employees\Exceptions\EmployeeCannotBeDeletedException;
use App\Models\Employees\Exceptions\EmployeeCannotBeUpdatedException;
use App\Models\Employees\Exceptions\EmployeeNotFoundException;

/**
 * EmployeesController
 * Model controller for table `rinku_employees`
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */
class Employees
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $code;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var int
     */
    private int $enum_rol;

    /**
     * @var int
     */
    private int $base_salary;

    /**
     * @var string
     */
    private string $creation_date;

    /**
     * @var string
     */
    private string $alias_table = 'employees';

    /**
     * @throws EmployeeNotFoundException
     */
    public function __construct(int $id = null)
    {
        if ($id != null) {
            // Instance of Sql class
            $o_mysql = new MySql();

            // $v_where Variable for where clause in the query
            $v_where = [
                'id = ?' => [
                    'type' => 'int',
                    'value' => $id,
                ]
            ];

            // Query in database
            $response = $o_mysql->select()->from($this->alias_table)->where($v_where)->execute();
            if (!empty($response['data'])) {
                $account_data = $response['data'];

                // Set properties of model
                $this->id = $account_data['id'];
                $this->code = $account_data['code'];
                $this->name = $account_data['name'];
                $this->enum_rol = $account_data['enum_rol'];
                $this->base_salary = $account_data['base_salary'];
                $this->creation_date = $account_data['creation_date'];
            } else {
                throw new EmployeeNotFoundException('Employee not found.');
            }
        }
    }

    /**
     * Get employee id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get code employee
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Set code employee
     *
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): Employees
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get employee name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set employee name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Employees
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get employee enum rol
     *
     * @return int
     */
    public function getEnumRol(): int
    {
        return $this->enum_rol;
    }

    /**
     * Set employee enum rol
     *
     * @param int $enum_rol
     * @return $this
     */
    public function setEnumRol(int $enum_rol): Employees
    {
        $this->enum_rol = $enum_rol;

        return $this;
    }

    /**
     * Get employee base salary
     *
     * @return int
     */
    public function getBaseSalary(): int
    {
        return $this->base_salary;
    }

    /**
     * Set employee base salary
     *
     * @param int $base_salary
     * @return $this
     */
    public function setBaseSalary(int $base_salary): Employees
    {
        $this->base_salary = $base_salary;

        return $this;
    }

    /**
     * Get employee creation date
     *
     * @return string
     */
    public function getCreationDate(): string
    {
        return $this->creation_date;
    }

    /**
     * Get all rows
     *
     * @return array
     */
    public function getAll(): array
    {
        // Instance of Sql class
        $o_mysql = new MySql();

        // Query in database
        $response = $o_mysql->select()->from($this->alias_table)->fetchAll()->execute();

        return $response['data'];
    }

    /**
     * Create a new employee
     *
     * @param Employees $employee
     * @return bool
     * @throws EmployeeCannotBeCreatedException
     */
    public function create(Employees $employee): bool
    {
        if (
            $employee->code != null &&
            $employee->name != null &&
            $employee->enum_rol != null
        ) {
            // Instance of Sql class
            $o_mySql = new MySql();

            $o_mySql->custom("
                CALL sp_EmployeeCreate('{$employee->code}', '{$employee->name}', {$employee->enum_rol});
            ")->execute();
        } else {
            throw new EmployeeCannotBeCreatedException('Employee can´t be created.');
        }

        return true;
    }

    /**
     * Update an existing employee
     *
     * @param Employees $employee
     * @return bool
     * @throws EmployeeCannotBeUpdatedException
     */
    public function update(Employees $employee): bool
    {
        if (
            $employee->id != null &&
            $employee->code != null &&
            $employee->name != null &&
            $employee->enum_rol != null
        ) {
            // Instance of Sql class
            $o_mySql = new MySql();

            $o_mySql->custom("
                CALL sp_EmployeeUpdate({$employee->id}, '{$employee->code}', '{$employee->name}', {$employee->enum_rol});
            ")->execute();
        } else {
            throw new EmployeeCannotBeUpdatedException('Employee can´t be updated.');
        }

        return true;
    }

    /**
     * Delete an employee
     *
     * @return bool
     * @throws EmployeeCannotBeDeletedException
     */
    public function delete(): bool
    {
        if ($this->id != null) {
            // Instance of Sql class
            $o_mySql = new MySql();

            $o_mySql->custom("
                CALL sp_EmployeeDelete({$this->id});
            ")->execute();
        } else {
            throw new EmployeeCannotBeDeletedException('Employee can´t be deleted.');
        }

        return true;
    }

}
