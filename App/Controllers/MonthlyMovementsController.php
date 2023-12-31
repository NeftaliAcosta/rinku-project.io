<?php

namespace App\Controllers;

use App\Core\SystemException;
use App\Enums\Roles;
use App\Libs\Tools;
use App\Libs\Validator;
use App\Models\Employees\Employees;
use App\Models\Employees\Exceptions\EmployeeNotFoundException;
use App\Models\MonthlyMovements\Exceptions\MonthlyMovementCannotBeCreatedException;
use App\Models\MonthlyMovements\Exceptions\MonthlyMovementCannotBeDeletedException;
use App\Models\MonthlyMovements\Exceptions\MonthlyMovementCannotBeUpdatedException;
use App\Models\MonthlyMovements\Exceptions\MonthlyMovementNotFoundException;
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
            $value['total_salary'] = '$' . number_format($value['extra_salary'] + $o_employee->getBaseSalary(), 2, '.', ',');
            $value['employee_code'] = $o_employee->getCode();
            $value['employee_name'] = $o_employee->getName();
            $value['employee_enum_rol'] = Roles::pretty($o_employee->getEnumRol());
            $value['employee_salary_base'] = '$' . number_format($o_employee->getBaseSalary(), 2, '.', ',');
            $value['grocery_vouchers'] = '$'.$value['grocery_vouchers'];
            $value['extra_salary'] = '$' . number_format($value['extra_salary'], 2, '.', ',');
            $value['taxes'] = $value['taxes'].'%';
            $value['month'] = Tools::getMonthName($value['month']);
        }

        // Controller response
        return $data;
    }

    /**
     * Save a new monthly movement
     *
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        // Variable response
        $response = [
            'success' => true,
            'message' => null
        ];

        // Get data information
        $employee_id = $data['employee_id'];
        $deliveries = $data['deliveries'];
        $month = $data['month'];

        // Validating input data
        $o_validator = new Validator();
        $o_validator->name('Empleado id')->value($employee_id)->required()->is_int()->min(1);
        $o_validator->name('Entregas')->value($deliveries)->required()->is_int()->min(1);
        $o_validator->name('Mes')->value($month)->required()->is_int()->min(1)->max(12);

        // Response if input data is valid
        if (!$o_validator->isSuccess()) {
            $response['success'] = false;
            $response['message'] = $o_validator->getErrorsHTML();

            return $response;
        }

        try {
            // Instance of object model MonthlyMovements
            $o_monthly_movements = new MonthlyMovements();

            // Set values required
            $o_monthly_movements->setEmployeeId($employee_id)
                ->setDeliveries($deliveries)
                ->setMonth($month);

            // Create new row
            $o_monthly_movements->create($o_monthly_movements);
        } catch (MonthlyMovementCannotBeCreatedException $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();

            return $response;
        }

        // Controller response
        return $response;
    }

    /**
     * Get monthly movement by id
     *
     */
    public function view(int $monthly_movement_id): array
    {
        // Variable response
        $response = [
            'success' => true,
            'message' => null,
            'data' => null
        ];

        try {
            // Instance of object model MonthlyMovements
            $o_monthly_movements = new MonthlyMovements($monthly_movement_id);

            $response['data']['employee_id'] = $o_monthly_movements->getEmployeeId();
            $response['data']['deliveries'] = $o_monthly_movements->getDeliveries();
            $response['data']['month'] = $o_monthly_movements->getMonth();
        } catch (MonthlyMovementNotFoundException $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();

            return $response;
        }

        // Controller response
        return $response;
    }

    /**
     * Update an existing monthly movement
     *
     * @param array $data
     * @return array
     */
    public function update(array $data): array
    {
        // Variable response
        $response = [
            'success' => true,
            'message' => null
        ];

        // Get data information
        $monthly_movements_id = $data['monthly_movements_id'];
        $deliveries = $data['deliveries'];
        $month = $data['month'];

        // Validating input data
        $o_validator = new Validator();
        $o_validator->name('Momiviento id')->value($monthly_movements_id)->required()->is_int()->min(1);
        $o_validator->name('Entregas')->value($deliveries)->required()->is_int()->min(1);
        $o_validator->name('Mes')->value($month)->required()->is_int()->min(1)->max(12);

        // Response if input data is valid
        if (!$o_validator->isSuccess()) {
            $response['success'] = false;
            $response['message'] = $o_validator->getErrorsHTML();

            return $response;
        }

        try {
            // Instance of object model MonthlyMovements
            $o_monthly_movements = new MonthlyMovements($monthly_movements_id);

            // Set values required
            $o_monthly_movements->setDeliveries($deliveries)
                ->setMonth($month);

            // Create new row
            $o_monthly_movements->update($o_monthly_movements);
        } catch (MonthlyMovementCannotBeUpdatedException|MonthlyMovementNotFoundException $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();

            return $response;
        }

        // Controller response
        return $response;
    }

    /**
     * Delete an existing monthly movement
     *
     * @param int $monthly_movement_id
     * @return array
     */
    public function delete(int $monthly_movement_id): array
    {
        // Variable response
        $response = [
            'success' => true,
            'message' => null
        ];

        // Validating input data
        $o_validator = new Validator();
        $o_validator->name('Movimiento mensual id')->value($monthly_movement_id)->required()->is_int()->min(1);

        // Response if input data is valid
        if (!$o_validator->isSuccess()) {
            $response['success'] = false;
            $response['message'] = $o_validator->getErrorsHTML();

            return $response;
        }

        try {
            // Instance of object model MonthlyMovements
            $o_monthly_movements = new MonthlyMovements($monthly_movement_id);

            // Delete monthly movement
            $o_monthly_movements->delete();
        } catch (MonthlyMovementCannotBeDeletedException|MonthlyMovementNotFoundException $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();

            return $response;
        }

        // Controller response
        return $response;
    }
}
