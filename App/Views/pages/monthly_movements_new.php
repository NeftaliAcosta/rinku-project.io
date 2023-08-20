<?php

// Load class
use App\Controllers\EmployeesController;
use App\Controllers\MonthlyMovementsController;
use App\Enums\Roles;
use App\Libs\Tools;

// Load information to build the form dynamically
$code = Tools::EmployeeCode();
$roles = Roles::getPrettyRolesArray();

$o_employee_controller = new EmployeesController();
$a_all_employees = $o_employee_controller->getAll();

// Logic to save new register
if (!empty($_POST)) {
    $o_monthly_movements_controller = new MonthlyMovementsController();
    $a_response = $o_monthly_movements_controller->create($_POST);

    if (!$a_response['success']) {
        echo "<div class='container alert alert-danger' role='alert'>{$a_response['message']}</div>";
    } else {
        echo "<div class='container alert alert-primary' role='alert'>Registro creado correctamente.</div>";
        header("refresh:1;url=" . $_ENV['__PATH__']. 'monthly-movements/all');
    }
}

?>

<div class="container pt-md-2">
    <h1 class="text-center">Nuevo registro mensual</h1>
</div>

<div class="container pt-md-5">
    <div class="container mt-5">
        <form action="<?php echo $_ENV['__PATH__']. 'monthly-movements/new' ?>" method="post">
            <div class="form-group">
                <label for="employee_id">Empleado</label>
                <select class="form-control" id="employee_id" name="employee_id">
                    <?php foreach ($a_all_employees as $key => $value): ?>
                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="deliveries">Entregas</label>
                <input type="number" class="form-control" id="deliveries" name="deliveries" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
</div>
