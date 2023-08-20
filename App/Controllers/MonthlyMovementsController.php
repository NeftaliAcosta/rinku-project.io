<?php

namespace App\Controllers;

use App\Core\SystemException;
use App\Enums\Roles;
use App\Models\Employees\Employees;
use App\Models\Employees\Exceptions\EmployeeNotFoundException;
use App\Models\MonthlyMovements\MonthlyMovements;
use Buki\Router\Http\Controller;

/**
 * EmployeesController
 * This is the controller of model Employees
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */
class MonthlyMovementsController extends Controller
{
    public function __invoke()
    {
    }

    /**
     * Get all row or searches
     *
     * @param int|null $month_to_search
     * @return array
     * @throws SystemException
     * @throws EmployeeNotFoundException
     */
    public function getAll(int|null $month_to_search = null): array
    {
        // Instance of object model MonthlyMovements
        $o_monthly_movements = new MonthlyMovements();

        // Get all rows
        $data = $o_monthly_movements->getAll($month_to_search);

        // Adding information in to array
        foreach ($data as &$value) {
            $o_employee = new Employees($value['employee_id']);
            $value['employee_code'] = $o_employee->getCode();
            $value['employee_name'] = $o_employee->getName();
            $value['employee_enum_rol'] = Roles::pretty($o_employee->getEnumRol());
            $value['employee_salary_base'] = '$'.$o_employee->getBaseSalary();
            $value['grocery_vouchers'] = '$'.$value['grocery_vouchers'];
            $value['extra_salary'] = '$'.$value['extra_salary'];
            $value['taxes'] = $value['taxes'].'%';
        }

        // Controller response
        return $data;
    }

}
