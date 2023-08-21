<?php

namespace App\Models\MonthlyMovements;

use App\Core\MySql\MySql;
use App\Models\MonthlyMovements\Exceptions\MonthlyMovementCannotBeCreatedException;
use App\Models\MonthlyMovements\Exceptions\MonthlyMovementCannotBeDeletedException;
use App\Models\MonthlyMovements\Exceptions\MonthlyMovementCannotBeUpdatedException;
use App\Models\MonthlyMovements\Exceptions\MonthlyMovementNotFoundException;

/**
 * MonthlyMovements
 * Model controller for table `rinku_monthly_movements`
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */
class MonthlyMovements
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $employee_id;

    /**
     * @var int
     */
    private int $deliveries;

    /**
     * @var int
     */
    private int $extra_salary;

    /**
     * @var int
     */
    private int $taxes;

    /**
     * @var float
     */
    private float $grocery_vouchers;

    /**
     * @var int
     */
    private int $month;

    /**
     * @var string
     */
    private string $creation_date;

    /**
     * @var string
     */
    private string $alias_table = 'monthly_movements';

    /**
     * @throws MonthlyMovementNotFoundException
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
                $this->employee_id = $account_data['employee_id'];
                $this->deliveries = $account_data['deliveries'];
                $this->extra_salary = $account_data['extra_salary'];
                $this->taxes = $account_data['taxes'];
                $this->grocery_vouchers = $account_data['grocery_vouchers'];
                $this->month = $account_data['month'];
                $this->creation_date = $account_data['creation_date'];
            } else {
                throw new MonthlyMovementNotFoundException('Monthly movement not found.');
            }
        }
    }

    /**
     * Get MonthlyMovements id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get MonthlyMovements Employee id
     *
     * @return int
     */
    public function getEmployeeId(): int
    {
        return $this->employee_id;
    }

    /**
     * Set MonthlyMovements employee_id
     *
     * @param int $employee_id
     * @return MonthlyMovements
     */
    public function setEmployeeId(int $employee_id): MonthlyMovements
    {
        $this->employee_id = $employee_id;

        return $this;
    }

    /**
     * Get MonthlyMovements deliveries
     *
     * @return int
     */
    public function getDeliveries(): int
    {
        return $this->deliveries;
    }

    /**
     * Set MonthlyMovements deliveries
     *
     * @param int $deliveries
     * @return MonthlyMovements
     */
    public function setDeliveries(int $deliveries): MonthlyMovements
    {
        $this->deliveries = $deliveries;

        return $this;
    }

    /**
     * Get MonthlyMovements extra salary
     *
     * @return int
     */
    public function getExtraSalary(): int
    {
        return $this->extra_salary;
    }

    /**
     * Set MonthlyMovements extra salary
     *
     * @param int $extra_salary
     * @return MonthlyMovements
     */
    public function setExtraSalary(int $extra_salary): MonthlyMovements
    {
        $this->extra_salary = $extra_salary;

        return $this;
    }

    /**
     * Get MonthlyMovements taxes
     *
     * @return int
     */
    public function getTaxes(): int
    {
        return $this->taxes;
    }

    /**
     * Set MonthlyMovements taxes
     *
     * @param int $taxes
     * @return MonthlyMovements
     */
    public function setTaxes(int $taxes): MonthlyMovements
    {
        $this->taxes = $taxes;

        return $this;
    }

    /**
     * Get MonthlyMovements grocery vouchers
     *
     * @return float
     */
    public function getGroceryVouchers(): float
    {
        return $this->grocery_vouchers;
    }

    /**
     * Set MonthlyMovements grocery vouchers
     *
     * @param float $grocery_vouchers
     * @return MonthlyMovements
     */
    public function setGroceryVouchers(float $grocery_vouchers): MonthlyMovements
    {
        $this->grocery_vouchers = $grocery_vouchers;

        return $this;
    }

    /**
     * Get MonthlyMovements month
     *
     * @return int
     */
    public  function getMonth(): int
    {
        return $this->month;
    }

    /**
     * Set MonthlyMovements month
     *
     * @param int $month
     * @return MonthlyMovements
     */
    public function setMonth(int $month): MonthlyMovements
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Set MonthlyMovements creation date
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
     * @param int|null $month_to_search
     * @return array
     */
    public function getAll(int|null $month_to_search): array
    {
        $current_year = date("Y");

        // Instance of Sql class
        $o_mysql = new MySql();

        if ($month_to_search != null) {
            // $v_where Variable for where clause in the query
            $v_where = [
                'YEAR(creation_date) = ?' => [
                    'type' => 'numeric',
                    'value' => $current_year,
                    'separator' => 'AND'
                ],
                'month = ?' => [
                    'type' => 'numeric',
                    'value' => $month_to_search
                ]
            ];

            // Query in database
            $response = $o_mysql->select()->from($this->alias_table)->where($v_where)->fetchAll()->execute();
        } else {
            // Query in database
            $response = $o_mysql->select()->from($this->alias_table)->fetchAll()->execute();
        }



        return $response['data'];
    }

    /**
     * Create a monthly movement
     *
     * @param MonthlyMovements $monthly_movement
     * @return bool
     * @throws MonthlyMovementCannotBeCreatedException
     */
    public function create(MonthlyMovements $monthly_movement): bool
    {
        if (
            $monthly_movement->employee_id != null &&
            $monthly_movement->deliveries != null &&
            $monthly_movement->month != null
        ) {
            // Instance of Sql class
            $o_mySql = new MySql();

            $o_mySql->custom("
                CALL sp_MonthlyMovementCreate({$monthly_movement->employee_id}, {$monthly_movement->deliveries}, $monthly_movement->month);
            ")->execute();
        } else {
            throw new MonthlyMovementCannotBeCreatedException('Monthly movement can´t be created.');
        }

        return true;
    }

    /**
     * Update a monthly movement
     *
     * @param MonthlyMovements $monthly_movement
     * @return bool
     * @throws MonthlyMovementCannotBeUpdatedException
     */
    public function update(MonthlyMovements $monthly_movement): bool
    {
        if (
            $monthly_movement->id != null &&
            $monthly_movement->deliveries != null &&
            $monthly_movement->month != null
        ) {
            // Instance of Sql class
            $o_mySql = new MySql();

            $o_mySql->custom("
                CALL sp_MonthlyMovementUpdate({$monthly_movement->id}, {$monthly_movement->deliveries}, {$monthly_movement->month});
            ")->execute();
        } else {
            throw new MonthlyMovementCannotBeUpdatedException('Monthly movement can´t be updated.');
        }

        return true;
    }

    /**
     * Delete a monthly movement
     *
     * @return bool
     * @throws MonthlyMovementCannotBeDeletedException
     */
    public function delete(): bool
    {
        if ($this->id != null) {
            // Instance of Sql class
            $o_mySql = new MySql();

            $o_mySql->custom("
                CALL sp_MonthlyMovementDelete({$this->id});
            ")->execute();
        } else {
            throw new MonthlyMovementCannotBeDeletedException('Monthly movement can´t be deleted.');
        }

        return true;
    }
}
