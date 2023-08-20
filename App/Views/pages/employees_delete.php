<?php
// Load class
use App\Controllers\EmployeesController;

// Logic to delete register
/** @var INT $employee_id */
$o_employee_controller = new EmployeesController();
$a_response = $o_employee_controller->delete($employee_id);

if (!$a_response['success']) {
    echo "<div class='container alert alert-danger' role='alert'>{$a_response['message']}</div>";
} else {
    echo "<div class='container alert alert-primary' role='alert'>Empleado eliminado correctamente.</div>";
    header("refresh:1;url=" . $_ENV['__PATH__']. 'employees/all');
}
?>

<div class="container pt-md-2">
    <h1 class="text-center">Eliminar empleado</h1>
</div>

