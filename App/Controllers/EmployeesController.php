<?php

namespace App\Controllers;

use App\Core\SystemException;
use App\Enums\Roles;
use App\Libs\Validator;
use App\Models\Employees\Employees;
use App\Models\Employees\Exceptions\EmployeeCannotBeCreatedException;

/**
 * EmployeesController
 * This is the controller of model Employees
 *
 * @author Neftalí Marciano Acosta <neftaliacosta@outlook.com>
 * @copyright (c) 2023, RINKU-PROJECT.io
 * @link https://rinku-project.io/
 * @version 1.0
 */
class EmployeesController
{
    /**
     * @throws SystemException
     */
    public function getAll(): array
    {
        $o_employees = new Employees();
        $data = $o_employees->getAll();

        // Convert enum value to pretty value from Enum Class
        foreach ($data as &$value) {
            $value['enum_rol'] = Roles::pretty($value['enum_rol']);
        }

        // Controller response
        return $data;
    }

    /**
     * Save new employee
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
        $code = $data['code'];
        $name = $data['name'];
        $enum_rol = $data['enum_rol'];
            $base_salary = $data['base_salary'];

        // Validating input data
        $o_validator = new Validator();
        $o_validator->name('Código')->value($code)->required()->is_alphanum()->minLength(5)->maxLength(5);
        $o_validator->name('Nombre')->value($name)->required()->is_alpha()->minLength(5)->maxLength(150);
        $o_validator->name('Rol')->value($enum_rol)->required()->is_int()->inArray(Roles::toArray());
        $o_validator->name('Base salarial')->value($base_salary)->required(false)->is_int();

        // Response if input data is valid
        if (!$o_validator->isSuccess()) {
            $response['success'] = false;
            $response['message'] = $o_validator->getErrorsHTML();

            return $response;
        }

        try {
            // Instance of object model Employees
            $o_employees = new Employees();

            // Set values required
            $o_employees->setCode($code)
                ->setName($name)
                ->setEnumRol($enum_rol);

            // Create new row
            $o_employees->create($o_employees);
        } catch (EmployeeCannotBeCreatedException $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();

            return $response;
        }

        // Controller response
        return $response;
    }
}
